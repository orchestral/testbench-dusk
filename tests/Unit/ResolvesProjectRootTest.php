<?php

namespace Orchestra\Testbench\Dusk\Tests\Unit;

use Orchestra\Testbench\Dusk\TestCase as TestbenchDuskTestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase as PHPUnitTestcase;

use function Illuminate\Filesystem\join_paths;
use function Orchestra\Testbench\Dusk\find_test_directory;

class ResolvesProjectRootTest extends PHPUnitTestCase
{
    #[Test]
    public function it_finds_the_correct_path_for_the_browser_tests()
    {
        $this->assertEquals(
            join_paths(realpath(join_paths(__DIR__, '..', '..')), 'tests', 'Browser'),
            find_test_directory()
        );
    }
}
