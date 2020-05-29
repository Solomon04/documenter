<?php


namespace Solomon04\Documentation\Annotation;

use Doctrine\Common\Annotations\Annotation\Attribute;
use Doctrine\Common\Annotations\Annotation\Enum;
use Doctrine\Common\Annotations\Annotation\Required;

/**
 * @Annotation
 */
class BodyParam
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
