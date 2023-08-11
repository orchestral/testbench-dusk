<?php

namespace Orchestra\Testbench\Dusk\Tests\Browser;

use Laravel\Dusk\Browser;
use Orchestra\Testbench\Dusk\TestCase;

class RouteTest extends TestCase
{
    /**
     * Define environment setup.
     *
     * @param  Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function defineEnvironment($app)
    {
        $app['router']->get('hello', ['uses' => function () {
            return 'hello world';
        }]);

        $app['router']->get('config', ['uses' => function () {
            return config('new_config_item');
        }]);

        $app['router']->get('environment', ['uses' => function () {
            return config('app.env');
        }]);
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
    public function can_return_correct_application_environment()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('environment')
                ->assertSee('testing');
        });
    }

    /** @test */
    public function can_use_multiple_browsers()
    {
        $this->browse(function (Browser $browser, Browser $browserTwo) {
            $browser->visit('hello')
                ->assertSee('hello world');

            $browserTwo->visit('hello')
                ->assertSee('hello world');
        });
    }

    /** @test */
    public function can_tweak_the_application_within_a_test()
    {
        $this->tweakApplication(function ($app, $config) {
            $config->set('new_config_item', 'Fantastic!');
        });

        $this->assertEquals('Fantastic!', config('new_config_item'));

        $this->browse(function (Browser $browser, Browser $browserTwo) {
            $browser->visit('config')
                ->assertSee('Fantastic!');
        });

        $this->removeApplicationTweaks();
    }
}
