<?php


use Solomon04\Documentation\Contracts\Writer;

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
}