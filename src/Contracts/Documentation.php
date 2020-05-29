<?php


namespace Solomon04\Documentation\Contracts;


use Solomon04\Documentation\Annotation\Endpoint;
use Solomon04\Documentation\Annotation\Group;
use Solomon04\Documentation\Exceptions\DocumentationException;
use Illuminate\Support\Collection;

interface Documentation
{
    /**
     * Get routes that can be documented
     *
     * @return Collection
     */
    public function getFilteredRoutes();

    /**
     * Get docs for an endpoint.
     *
     * @param Endpoint $endpoint
     * @return Endpoint
     * @throws DocumentationException
     * @throws \ReflectionException
     */
    public function getMethodDocBlock(Endpoint $endpoint);

    /**
     * Get the group from a class.
     *
     * @param $key
     * @return Group
     * @throws \ReflectionException
     */
    public function getClassDocBlocks($key);

    /**
     * Group endpoints by class and namespace.
     *
     * @param Collection $endpoints
     * @return Collection
     */
    public function groupEndpoints(Collection $endpoints);
}
