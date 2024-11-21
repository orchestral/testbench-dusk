<?php

namespace Orchestra\Testbench\Dusk\Tests\Feature;

use Exception;
use Orchestra\Testbench\Dusk\TestCase;
use PHPUnit\Framework\Attributes\Test;

class TestCaseTest extends TestCase
{
    #[Test]
    public function it_throws_exception_when_trying_to_access_user()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('User resolver has not been set.');

        $this->user();
    }
}
