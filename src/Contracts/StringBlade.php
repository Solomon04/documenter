<?php


namespace Solomon04\Documentation\Contracts;


interface StringBlade
{
    /**
     * Get the rendered HTML.
     *
     * @param $bladeString
     * @param array $data
     * @return bool|string
     */
    public function render($bladeString, $data = []);
}
