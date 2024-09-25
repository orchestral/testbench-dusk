<?php

namespace Orchestra\Testbench\Dusk\Tests\Unit;

use PHPUnit\Framework\TestCase;

use function Orchestra\Testbench\join_paths;
use function Orchestra\Testbench\package_path;

class ResolvesProjectRootTest extends TestCase
{
    /** @test */
    public function it_finds_the_correct_path_for_the_browser_tests()
    {
        $this->assertEquals(
            join_paths(realpath(join_paths(__DIR__, '..', '..')), 'tests', 'Browser'),
            package_path('tests', 'Browser')
        );
    }
}
