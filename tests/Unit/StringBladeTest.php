<?php

use Solomon04\Documentation\Contracts\StringBlade;

/**
 * @coversDefaultClass \Solomon04\Documentation\StringBladeProvider
 */
class StringBladeTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \Mockery\LegacyMockInterface|\Mockery\MockInterface|StringBlade
     */
    private $stringBlade;

    protected function setUp(): void
    {
        parent::setUp();
        $this->stringBlade = Mockery::mock(StringBlade::class);
    }

    /**
     * @covers ::render
     */
    public function testRender()
    {
        $this->stringBlade->shouldReceive('render')
            ->with('foo', ['a' => 'b'])
            ->andReturn('bar');

        $result = $this->stringBlade->render('foo', ['a' => 'b']);

        $this->assertSame('bar', $result);
    }
}