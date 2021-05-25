<?php

namespace Orchestra\Testbench\Dusk\Tests\Unit;

use Orchestra\Testbench\Dusk\TestCase as TestbenchDuskTestCase;
use PHPUnit\Framework\TestCase as PHPUnitTestcase;

class ResolvesProjectRootTest extends PHPUnitTestCase
{
    /** @test */
    public function it_finds_the_correct_path_for_the_browser_tests()
    {
        $this->assertEquals(
            '/home/person/code/testbench-dusk/tests/Browser',
            (new DummyTestCase())->resolveBrowserTestsPath('/home/person/code/testbench-dusk/src')
        );

        $this->assertEquals(
            '/home/person/code/project/tests/Browser',
            (new DummyTestCase())->resolveBrowserTestsPath('/home/person/code/project/vendor/orchestra/testbench-dusk/src')
        );
    }
}

class DummyTestCase extends TestbenchDuskTestCase
{
    public function resolveBrowserTestsPath($path = __DIR__)
    {
        return parent::resolveBrowserTestsPath($path);
    }

    // Added so PHPUnit doesn't warn about not tests being found in this class.
    public function testQuietly()
    {
        $this->assertTrue(true);
    }

    // Don't try to start another server!
    public static function setUpBeforeClass(): void
    {
        //
    }

    // Don't need to stop a server
    public static function tearDownAfterClass(): void
    {
        //
    }
}
