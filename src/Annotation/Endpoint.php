<?php


namespace Solomon04\Documentation\Annotation;

/**
 * @Annotation
 */
class Endpoint
{
    /**
     * @var string
     */
    public $uri;

    /**
     * @var string
     */
    public $httpMethod;

    /**
     * @var boolean
     */
    public $requiresAuth;

    /**
     * @var string
     */
    public $namespace;

    /**
     * @var string
     */
    public $class;

    /**
     * @var string
     */
    public $classMethod;

    /**
     * @var Meta|null
     */
    public $meta;

    /**
     * @var ResponseExample[]|ResponseExample|null
     */
    public $response;

    /**
     * @var BodyParam[]|BodyParam|null
     */
    public $bodyParams;

    /**
     * @var null
     */
    public $queryParams;
}
