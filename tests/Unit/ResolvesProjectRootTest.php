<?php

namespace Orchestra\Testbench\Dusk\Tests\Unit;

use PHPUnit\Framework\TestCase;

use function Orchestra\Testbench\Dusk\find_test_directory;
use function Orchestra\Testbench\join_paths;

class ResolvesProjectRootTest extends TestCase
{
    /** @test */
    public function it_finds_the_correct_path_for_the_browser_tests()
    {
        $this->assertEquals(
            join_paths(realpath(join_paths(__DIR__, '..', '..')), 'tests', 'Browser'),
            find_test_directory()
        );
    }
}
