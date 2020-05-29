<?php


namespace Solomon04\Documentation\Annotation;

use Doctrine\Common\Annotations\Annotation\Attribute;
use Doctrine\Common\Annotations\Annotation\Enum;
use Doctrine\Common\Annotations\Annotation\Required;
use Solomon04\Documentation\Exceptions\AnnotationException;

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

    public static function validate(array $bodyParam)
    {
        if (!isset($bodyParam['name']) && !is_string($bodyParam['name'])) {
            throw new AnnotationException('The name of the @BodyParam is invalid or undefined.');
        }

        if (!isset($bodyParam['type']) && !is_string($bodyParam['type'])) {
            throw new AnnotationException('The type of the @BodyParam is invalid or undefined.');
        }

        if (!isset($bodyParam['status']) && !is_string($bodyParam['status'])) {
            throw new AnnotationException('The status of the @BodyParam is invalid or undefined.');
        }
        
        return;
    }
}
