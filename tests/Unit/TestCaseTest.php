<?php

namespace Orchestra\Testbench\Dusk\Tests\Unit;

use Orchestra\Testbench\Dusk\TestCase as DuskTestCase;
use PHPUnit\Framework\TestCase;

class TestCaseTest extends TestCase
{
    /** @test */
    public function it_can_resolve_default_configuration()
    {
        $this->assertSame(\sprintf('http://%s:%d', DuskTestCase::getBaseServeHost(), DuskTestCase::getBaseServePort()), DuskTestCase::applicationBaseUrl());
        $this->assertSame(DuskTestCase::applicationBaseUrl(), DuskTestCase::baseServeUrl());
    }
}
