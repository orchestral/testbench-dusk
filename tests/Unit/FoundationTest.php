<?php

namespace Orchestra\Testbench\Dusk\Tests\Unit;

use Orchestra\Testbench\Dusk\Foundation;
use PHPUnit\Framework\TestCase;

class FoundationTest extends TestCase
{
    /** @test */
    public function it_finds_the_correct_path_for_the_browser_tests()
    {
        $this->assertEquals(
            '/home/person/code/testbench-dusk/tests/Browser',
            (new TestFoundation)->resolveBrowserTestsPath('/home/person/code/testbench-dusk/src')
        );

        $this->assertEquals(
            '/home/person/code/project/tests/Browser',
            (new TestFoundation)->resolveBrowserTestsPath('/home/person/code/project/vendor/orchestra/testbench-dusk/src')
        );
    }
}

class TestFoundation extends Foundation
{
    public function resolveBrowserTestsPath($path = __DIR__)
    {
        return parent::resolveBrowserTestsPath($path);
    }
}
