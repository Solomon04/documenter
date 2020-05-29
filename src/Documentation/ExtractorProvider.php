<?php


namespace Solomon04\Documentation;


use Solomon04\Documentation\Annotation\BodyParam;
use Solomon04\Documentation\Annotation\Group;
use Solomon04\Documentation\Annotation\Meta;
use Solomon04\Documentation\Annotation\QueryParam;
use Solomon04\Documentation\Annotation\ResponseExample;
use Solomon04\Documentation\Contracts\Extractor;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Validation\Factory as Validator;
use Illuminate\Validation\ValidationException;
use Solomon04\Documentation\Exceptions\AnnotationException;

class ExtractorProvider implements Extractor
{

    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @var Validator
     */
    private $validator;

    public function __construct(Filesystem $filesystem, Validator $validator)
    {
        $this->filesystem = $filesystem;
        $this->validator = $validator;
    }

    /**
     * Strip the response annotation from a controller.
     *
     * @param string $response
     * @return ResponseExample
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     * @throws AnnotationException
     */
    public function response(string $response)
    {
        $stringedArray = explode(',', str_replace(array( '(', ')' ), '', $response));
        $responses = [];
        $responseExample = new ResponseExample();
        foreach ($stringedArray as $arr) {
            $data = explode('=', $arr);

            $name = preg_replace('/\s+/', '', $data[0]);

            $responses[$name] = $data[1];
        }

        ResponseExample::validate($responses);

        foreach ($responses as $item => $value) {
            $responseExample->$item = str_replace('"', '', $value);
        }

        $example = storage_path($responseExample->example);
        $responseExample->example = $this->filesystem->get($example);


        return $responseExample;
    }

    /**
     * Strip the meta annotation from a controller method.
     *
     * @param string $meta
     * @return Meta|string
     * @throws AnnotationException
     */
    public function meta(string $meta)
    {
        $stringedArray = explode(',', str_replace(array( '(', ')'), '', $meta));
        $meta = new Meta();
        $params = [];
        foreach ($stringedArray as $arr) {
            $data = explode('=', $arr);

            $name = preg_replace('/\s+/', '', $data[0]);

            $params[$name] = $data[1];
        }

        Meta::validate($params);

        foreach ($params as $item => $value) {
            $meta->$item = str_replace('"', '', $value);;
        }

        return $meta;
    }

    /**
     * Strip the group annotation from the controller.
     *
     * @param string $group
     * @return Group|string
     * @throws AnnotationException
     */
    public function group(string $group)
    {
        $stringedArray = explode(',', str_replace(array( '(', ')'), '', $group));
        $group = new Group();
        $params = [];
        foreach ($stringedArray as $arr) {
            $data = explode('=', $arr);

            $name = preg_replace('/\s+/', '', $data[0]);

            $params[$name] = $data[1];
        }

        Group::validate($params);

        foreach ($params as $item => $value) {
            $group->$item = str_replace('"', '', $value);
        }

        return $group;
    }

    /**
     * Strip the body param annotation from the controller.
     *
     * @param string $body
     * @return BodyParam|string
     * @throws AnnotationException
     */
    public function body(string $body)
    {
        $stringedArray = explode(',', str_replace(array( '(', ')'), '', $body));
        $params = [];
        $body = new BodyParam();
        foreach ($stringedArray as $arr) {
            $data = explode('=', $arr);

            $name = preg_replace('/\s+/', '', $data[0]);

            $params[$name] = $data[1];
        }

        BodyParam::validate($params);

        foreach ($params as $item => $value) {
            $body->$item = str_replace('"', '', $value);
        }

        return $body;
    }

    /**
     * Strip the query param annotation from the controller.
     *
     * @param string $query
     * @return QueryParam|string
     * @throws AnnotationException
     */
    public function query(string $query)
    {
        $stringedArray = explode(',', str_replace(array( '(', ')'), '', $query));
        $params = [];
        $query = new QueryParam();
        foreach ($stringedArray as $arr) {
            $data = explode('=', $arr);

            $name = preg_replace('/\s+/', '', $data[0]);

            $params[$name] = $data[1];
        }

        QueryParam::validate($params);

        foreach ($params as $item => $value) {
            $query->$item = str_replace('"', '', $value);
        }


        return $query;
    }

}
