<?php


namespace Solomon04\Documentation\Annotation;

use Solomon04\Documentation\Exceptions\AnnotationException;

/**
 * @Annotation
 */
class Meta
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $description = '';

    /**
     * @var string
     */
    public $href;

    public static function validate(array $meta)
    {
        if (!isset($meta['name']) && !is_string($meta['name'])) {
            throw new AnnotationException('The name of the @Meta is invalid or undefined.');
        }

        if (!isset($meta['href']) && !is_string($meta['href'])) {
            throw new AnnotationException('The href of the @Meta is invalid or undefined.');
        }

        return $meta;
    }
}
