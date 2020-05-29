<?php


namespace Solomon04\Documentation\Annotation;

use Solomon04\Documentation\Exceptions\AnnotationException;

/**
 * @Annotation
 */
class Group
{
    /**
     * @var string
     */
    public $name = 'General';

    /**
     * @var string
     */
    public $description = '';

    public static function validate(array $group)
    {
        if (!isset($group['name']) && !is_string($group['name'])) {
            throw new AnnotationException('The name of the @Group is invalid or undefined.');
        }

        return $group;
    }
}
