<?php

namespace Orchestra\Testbench\Dusk\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Orchestra\Testbench\Dusk\DuskServer;

class DuskServerTest extends TestCase
{
    /** @test */
    public function it_provides_the_laravel_public_directory()
    {
        $this->assertEquals(
            realpath(__DIR__.'/../../laravel/public'),
            (new DuskServer())->laravelPublicPath()
        );
    }

    /** @test */
    public function it_provides_the_laravel_public_directory_from_custom_location()
    {
        $this->assertEquals(
            '/dir/project/laravel/public',
            (new DuskServer())->laravelPublicPath('/dir/project/laravel/public')
        );
    }
}
