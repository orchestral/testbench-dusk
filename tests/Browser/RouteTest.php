<?php

namespace Orchestra\Testbench\Tests\Browser;

use Laravel\Dusk\Browser;
use Orchestra\Testbench\CanServeSite;
use Orchestra\Testbench\Dusk\TestCase;

class RouteTest extends TestCase
{
    /**
     * Define environment setup.
     *
     * @param  Illuminate\Foundation\Application    $app
     *
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('app.url', 'http://localhost:8000');

        $app['router']->get('hello', ['as' => 'hi', 'uses' => function () {
            return 'hello world';
        }]);
    }

    /** @test */
    public function can_use_dusk()
    {
        $this->serve();

        $this->browse(function (Browser $browser) {
            $browser->visit('hello')
                ->assertSee('hello world');
        });

        $this->stopServing();
    }
}
