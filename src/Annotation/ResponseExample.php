<?php


namespace Solomon04\Documentation\Annotation;

use Solomon04\Documentation\Exceptions\AnnotationException;

/**
 * @Annotation
 */
class ResponseExample
{
    /**
     * @var int
     */
    public $status = 200;

    /**
     * @var null|string
     */
    public $example = null;

    public static function validate(array $responseExample)
    {
        if (!isset($responseExample['status']) && !is_numeric($responseExample['status'])) {
            throw new AnnotationException('The name of the @ResponseExample is invalid or undefined.');
        }

        if (!file_exists(storage_path(str_replace('"', '', $responseExample['example'])))) {
            throw new AnnotationException('The file in the @ResponseExample is invalid or does not exist.');
        }

        return $responseExample;
    }
}
