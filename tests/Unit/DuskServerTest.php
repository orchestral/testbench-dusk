<?php

namespace Orchestra\Testbench\Tests;

use PHPUnit\Framework\TestCase;
use Orchestra\Testbench\DuskServer;

class DuskServerTest extends TestCase
{
    /** @test */
    public function it_provides_the_laravel_public_directory_when_it_is_a_root_package()
    {
        $this->assertEquals(
            '/dir/testbench-dusk/vendor/orchestra/testbench-core/laravel/public',
            (new DuskServer())->laravelPublicPath('/dir/testbench-dusk/src')
        );
    }

    /** @test */
    public function it_provides_the_laravel_public_directory_when_it_is_a_required_package()
    {
        $this->assertEquals(
            '/dir/project/vendor/orchestra/testbench-core/laravel/public',
            (new DuskServer())->laravelPublicPath('/dir/project/vendor/orchestra/testbench-dusk/src')
        );
    }
}
