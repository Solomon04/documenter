<?php


namespace Solomon04\Documentation\Annotation;


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
}
