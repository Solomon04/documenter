<?php


use PHPUnit\Framework\TestCase;
use Solomon04\Documentation\Annotation\BodyParam;
use Solomon04\Documentation\Annotation\Group;
use Solomon04\Documentation\Annotation\Meta;
use Solomon04\Documentation\Annotation\QueryParam;
use Solomon04\Documentation\Annotation\ResponseExample;
use Solomon04\Documentation\Contracts\Extractor;

/**
 * @coversDefaultClass \Solomon04\Documentation\ExtractorProvider
 */
class ExtractorTest extends TestCase
{
    /**
     * @var \Mockery\LegacyMockInterface|\Mockery\MockInterface|Extractor
     */
    private $extractor;

    protected function setUp(): void
    {
        parent::setUp();
        $this->extractor = Mockery::mock(Extractor::class);
    }

    /**
     * @covers ::response
     */
    public function testResponse()
    {
        $responseExample = new ResponseExample();
        $this->extractor->shouldReceive('response')
            ->with('foo')
            ->andReturn($responseExample);

        $result = $this->extractor->response('foo');

        $this->assertSame($responseExample, $result);
    }

    /**
     * @covers ::meta
     */
    public function testMeta()
    {
        $meta = new Meta();
        $this->extractor->shouldReceive('meta')
            ->with('foo')
            ->andReturn($meta);

        $result = $this->extractor->meta('foo');

        $this->assertSame($meta, $result);
    }

    /**
     * @covers ::group
     */
    public function testGroup()
    {
        $group = new Group();

        $this->extractor->shouldReceive('group')->with('foo')->andReturn($group);

        $result = $this->extractor->group('foo');

        $this->assertSame($group, $result);
    }

    /**
     * @covers ::body
     */
    public function testBody()
    {
        $body = new BodyParam();

        $this->extractor->shouldReceive('body')->with('foo')->andReturn($body);

        $result = $this->extractor->body('foo');

        $this->assertSame($body, $result);
    }

    /**
     * @covers ::query
     */
    public function testQuery()
    {
        $query = new QueryParam();

        $this->extractor->shouldReceive('query')->with('foo')->andReturn($query);

        $result = $this->extractor->query('foo');

        $this->assertSame($query, $result);
    }
}