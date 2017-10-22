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
        $app['config']->set('app.url', 'http://127.0.0.1:8000');

        $app['router']->get('hello', ['as' => 'hi', 'uses' => function () {
            return 'hello world';
        }]);
    }

    public static function setUpBeforeClass()
    {
        static::serve();
    }

    public static function tearDownAfterClass()
    {
        static::stopServing();
    }

    /** @test */
    public function can_use_dusk()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('hello')
                ->assertSee('hello world');
        });
    }

    /** @test */
    public function can_use_mulitple_browsers()
    {
        $this->browse(function (Browser $browser, Browser $browserTwo) {
            $browser->visit('hello')
                ->assertSee('hello world');

            $browserTwo->visit('hello')
                ->assertSee('hello world');
        });
    }
}
