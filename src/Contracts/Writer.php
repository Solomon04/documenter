<?php


namespace Solomon04\Documentation\Contracts;


use Illuminate\Support\Collection;

interface Writer
{
    /**
     * Create the documentation menu
     *
     * @param Collection $namespaces
     * @return bool|int
     */
    public function menu(Collection $namespaces);

    /**
     * Create the endpoint pages
     *
     * @param Collection $endpoints
     * @param string $name
     * @return bool|int
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function page($endpoints, $name);
}
