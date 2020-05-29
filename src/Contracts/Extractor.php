<?php


namespace Solomon04\Documentation\Contracts;


use Solomon04\Documentation\Annotation\BodyParam;
use Solomon04\Documentation\Annotation\Meta;
use Solomon04\Documentation\Annotation\QueryParam;
use Solomon04\Documentation\Annotation\ResponseExample;
use Illuminate\Validation\ValidationException;

interface Extractor
{
    /**
     * Strip the response annotation from a controller.
     *
     * @param string $response
     * @return ResponseExample
     * @throws ValidationException
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function response(string $response);

    /**
     * Strip the meta annotation from the controller.
     *
     * @param string $meta
     * @return Meta|string
     * @throws ValidationException
     */
    public function meta(string $meta);

    /**
     * Strip the group annotation from the controller.
     *
     * @param string $group
     * @return Meta|string
     * @throws ValidationException
     */
    public function group(string $group);

    /**
     * Strip the body param annotation from the controller.
     *
     * @param string $body
     * @return BodyParam|string
     * @throws ValidationException
     */
    public function body(string $body);

    /**
     * Strip the query param annotation from the controller.
     *
     * @param string $query
     * @return QueryParam|string
     * @throws ValidationException
     */
    public function query(string $query);
}
