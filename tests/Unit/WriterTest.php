<?php


use Illuminate\Support\Collection;
use Solomon04\Documentation\Contracts\Writer;

/**
 * @coversDefaultClass \Solomon04\Documentation\WriterProvider
 */
class WriterTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \Mockery\LegacyMockInterface|\Mockery\MockInterface|Writer
     */
    private $writer;

    protected function setUp(): void
    {
        parent::setUp();
        $this->writer = Mockery::mock(Writer::class);
    }

    /**
     * @covers ::menu
     */
    public function testGenerateMenu()
    {
        $namespaces = new Collection();

        $this->writer->shouldReceive('menu')->with($namespaces)->andReturn(true);

        $this->assertTrue($this->writer->menu($namespaces));
    }

    /**
     * @covers ::page
     */
    public function testGeneratePage()
    {
        $endpoints = new Collection();

        $this->writer->shouldReceive('page')->with($endpoints, 'foo')->andReturn(true);

        $this->assertTrue($this->writer->page($endpoints, 'foo'));
    }
}