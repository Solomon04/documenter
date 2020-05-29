<?php


namespace Solomon04\Documentation\Annotation;


use Solomon04\Documentation\Exceptions\AnnotationException;

/**
 * @Annotation
 */
class QueryParam
{
    /**
     * @var
     */
    public $name;

    /**
     * @var
     */
    public $type = 'string';

    /**
     * @var
     */
    public $status = 'required';

    /**
     * @var
     */
    public $description = '';

    /**
     * @var
     */
    public $example = null;

    public static function validate(array $queryParam)
    {
        if (!isset($queryParam['name']) && !is_string($queryParam['name'])) {
            throw new AnnotationException('The name of the @QueryParam is invalid or undefined.');
        }

        if (!isset($queryParam['type']) && !is_string($queryParam['type'])) {
            throw new AnnotationException('The type of the @QueryParam is invalid or undefined.');
        }

        if (!isset($queryParam['status']) && !is_string($queryParam['status'])) {
            throw new AnnotationException('The status of the @QueryParam is invalid or undefined.');
        }

        return;
    }
}
