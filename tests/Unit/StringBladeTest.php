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


}