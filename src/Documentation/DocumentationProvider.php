<?php


namespace Solomon04\Documentation;


use Solomon04\Documentation\Annotation\Endpoint;
use Solomon04\Documentation\Annotation\Group;
use Solomon04\Documentation\Contracts\Documentation;
use Solomon04\Documentation\Contracts\Extractor;
use Solomon04\Documentation\Exceptions\DocumentationException;
use Illuminate\Routing\Router;
use Illuminate\Support\Collection;
use Minime\Annotations\Interfaces\ReaderInterface;
use ReflectionClass;

class DocumentationProvider implements Documentation
{
    const RESPONSE = 'ResponseExample';
    const BODY_PARAM = 'BodyParam';
    const QUERY_PARAM = 'QueryParam';
    const META = 'Meta';
    const GROUP = 'Group';

    /**
     * @var \Minime\Annotations\Interfaces\ReaderInterface
     */
    private $reader;

    /**
     * @var Router
     */
    private $router;

    /**
     * @var Extractor
     */
    private $extractor;

    /**
     * @var array
     */
    public $accepted = ['api'];


    public function __construct(ReaderInterface $reader, Router $router, Extractor $extractor)
    {
        $this->reader = $reader;
        $this->router = $router;
        $this->extractor = $extractor;
    }

    /**
     * Get routes that can be documented
     *
     * @return Collection
     */
    public function getFilteredRoutes()
    {
        $routes = $this->router->getRoutes()->getRoutes();
        $filtered = new Collection();
        foreach ($routes as $route) {
            if (!is_array($route->action['middleware'])) {
                continue;
            }

            if (array_intersect(config('documentation.documentable_routes'), $route->action['middleware']) < 1) {
                continue;
            }

            if (!is_string($route->action['uses'])) {
                continue;
            }

            $uses = explode("@", (string)$route->action['uses']);

            // check if uri already has forward slash. If missing, this will add it.
            $uri = (substr($route->uri, 0, 1) === '/') ? $route->uri : DIRECTORY_SEPARATOR . $route->uri;
            $endpoint = new Endpoint();
            $endpoint->uri = $uri;
            $endpoint->httpMethod = $route->methods[0];
            $endpoint->requiresAuth = array_intersect(config('documentation.auth_middleware'), (array)$route->middleware()) > 0;
            $endpoint->class = $uses[0];
            $endpoint->classMethod = $uses[1];

            $filtered->add($endpoint);
        }

        return $filtered;
    }

    /**
     * Get docs for an endpoint.
     *
     * @param Endpoint $endpoint
     * @return Endpoint
     * @throws DocumentationException
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     * @throws \Illuminate\Validation\ValidationException
     * @throws \ReflectionException
     * @throws Exceptions\AnnotationException
     */
    public function getMethodDocBlock(Endpoint $endpoint)
    {
        $annotations = $this->reader->getMethodAnnotations($endpoint->class, $endpoint->classMethod);
        $metaAnnotations = $annotations->get(self::META);
        $responseAnnotations = $annotations->get(self::RESPONSE);
        $bodyAnnotations = $annotations->get(self::BODY_PARAM);
        $queryAnnotations = null;

        if (!is_null($metaAnnotations)) {
            if (is_array($metaAnnotations)) {
                throw new DocumentationException(
                    sprintf(
                        'The method %s in %s can only have one @Meta annotation',
                        $endpoint->classMethod,
                        $endpoint->class
                    )
                );
            }

            $endpoint->meta = $this->extractor->meta($metaAnnotations);

        }


        if (!is_null($responseAnnotations)) {
            if (is_array($responseAnnotations)) {
                foreach ($responseAnnotations as $responseAnnotation) {
                    $endpoint->response[] = $this->extractor->response($responseAnnotation);
                }
            } else {
                $endpoint->response = $this->extractor->response($responseAnnotations);
            }
        }

        if (!is_null($bodyAnnotations)) {
            if (is_array($bodyAnnotations)) {
                foreach ($bodyAnnotations as $bodyAnnotation) {
                    $endpoint->bodyParams[] = $this->extractor->body($bodyAnnotation);
                }
            } else {
                $endpoint->bodyParams = $this->extractor->body($bodyAnnotations);
            }
        }

        return $endpoint;
    }

    /**
     * Get the group from a class.
     *
     * @param $key
     * @return Group|string
     * @throws \ReflectionException
     * @throws Exceptions\AnnotationException
     */
    public function getClassDocBlocks($key)
    {
        $classAnnotation = $this->reader->getClassAnnotations($key)->get(self::GROUP);
        if(!is_null($classAnnotation)) {
            return $this->extractor->group($classAnnotation);
        }else {
            return new Group();
        }
    }

    /**
     * Group endpoints by class and namespace.
     *
     * @param Collection $endpoints
     * @return Collection
     */
    public function groupEndpoints(Collection $endpoints)
    {
        // group by class
        $endpoints = $endpoints->groupBy(function (Endpoint $endpoint) {
            return $endpoint->class;
        });


        return $endpoints->groupBy(function ($item, $key){
            $r =  new ReflectionClass($key);
            $item->group = $this->getClassDocBlocks($key);
            return str_replace(config('documentation.controller_path'), '', $r->getNamespaceName());
        }, true);
    }
}
