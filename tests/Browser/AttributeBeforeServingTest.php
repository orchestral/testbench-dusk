<?php

namespace Orchestra\Testbench\Dusk\Tests\Browser;

use Laravel\Dusk\Browser;
use Orchestra\Testbench\Dusk\Attributes\BeforeServing;
use Orchestra\Testbench\Dusk\TestCase;
use PHPUnit\Framework\Attributes\Test;

class AttributeBeforeServingTest extends TestCase
{
    /**
     * Define routes setup.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    protected function defineRoutes($router)
    {
        $router->get('config', ['uses' => function () {
            return config('new_config_item');
        }]);
    }

    #[Test]
    #[BeforeServing('defineCustomConfiguration')]
    public function can_tweak_the_application_within_a_test()
    {
        $this->assertEquals('Fantastic!', config('new_config_item'));

        $this->browse(function (Browser $browser, Browser $browserTwo) {
            $browser->visit('config')
                ->assertSee('Fantastic!');
        });
    }

    #[Test]
    public function application_tweak_doesnt_persist_between_test()
    {
        $this->assertNull($this->app['config']->get('new_config_item'));
    }

    /**
     * Define custom configuration.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @param  \Illuminate\Contracts\Config\Repository  $config
     * @return void
     */
    protected function defineCustomConfiguration($app, $config)
    {
        $config->set('new_config_item', 'Fantastic!');
    }
}
