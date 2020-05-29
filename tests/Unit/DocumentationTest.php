<?php


use Illuminate\Support\Collection;
use PHPUnit\Framework\TestCase;
use Solomon04\Documentation\Annotation\Endpoint;
use Solomon04\Documentation\Annotation\Group;
use Solomon04\Documentation\Contracts\Documentation;
use Solomon04\Documentation\Exceptions\DocumentationException;

/**
 * @coversDefaultClass \Solomon04\Documentation\DocumentationProvider
 */
class DocumentationTest extends TestCase
{
    /**
     * @var \Mockery\LegacyMockInterface|\Mockery\MockInterface|Documentation
     */
    private $documentation;

    protected function setUp(): void
    {
        parent::setUp();
        $this->documentation = Mockery::mock(Documentation::class);
    }

    /**
     * @covers ::getFilteredRoutes
     */
    public function testGetFilteredRoutes()
    {
        $collection = new Collection();
        $this->documentation->shouldReceive('getFilteredRoutes')->andReturn($collection);
        $routes = $this->documentation->getFilteredRoutes();
        $this->assertSame($collection, $routes);
    }

    /**
     * @covers ::getMethodDocBlock
     */
    public function testGetMethodDocBlock()
    {
        $endpoint = new Endpoint();
        $this->documentation->shouldReceive('getMethodDocBlock')
            ->with($endpoint)
            ->andReturn($endpoint);

        $this->assertSame($endpoint, $this->documentation->getMethodDocBlock($endpoint));
    }

    /**
     * @covers ::getMethodDocBlock
     */
    public function testThrowsDocumentationException()
    {
        $this->expectException(DocumentationException::class);
        $endpoint = new Endpoint();
        $this->documentation->shouldReceive('getMethodDocBlock')
            ->with($endpoint)
            ->andThrow(DocumentationException::class);

        $this->documentation->getMethodDocBlock($endpoint);
    }

    /**
     * @covers ::getClassDocBlocks
     */
    public function testGetClassDocBlocks()
    {
        $group = new Group();
        $this->documentation->shouldReceive('getClassDocBlocks')
            ->with('foo')
            ->andReturn($group);

        $result = $this->documentation->getClassDocBlocks('foo');
        $this->assertSame($group, $result);
    }

    /**
     * @covers ::groupEndpoints
     */
    public function testGroupEndpoints()
    {
        $collection = new Collection();

        $this->documentation->shouldReceive('groupEndpoints')
            ->with($collection)
            ->andReturn($collection);

        $result = $this->documentation->groupEndpoints($collection);

        $this->assertSame($collection, $result);
    }
}