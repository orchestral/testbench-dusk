<?php

namespace Orchestra\Testbench\Dusk\Tests\Feature;

use Exception;
use Orchestra\Testbench\Dusk\TestCase;

class TestCaseTest extends TestCase
{
    /** @test */
    public function it_can_resolve_default_configuration()
    {
        $this->assertSame(static::applicationBaseUrl(), $this->baseUrl());
    }

    /** @test */
    public function it_throws_exception_when_trying_to_access_user()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('User resolver has not been set.');

        $this->user();
    }
}
