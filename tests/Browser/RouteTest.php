<?php

namespace Orchestra\Testbench\Dusk\Tests\Browser;

use Illuminate\Support\Env;
use Laravel\Dusk\Browser;
use Orchestra\Testbench\Dusk\TestCase;
use PHPUnit\Framework\Attributes\Test;

use function Orchestra\Testbench\package_path;

class RouteTest extends TestCase
{
    /**
     * Define routes setup.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    protected function defineRoutes($router)
    {
        $router->get('hello', ['uses' => function () {
            return 'hello world';
        }]);

        $router->get('config', ['uses' => function () {
            return config('new_config_item');
        }]);

        $router->get('environment', ['uses' => function () {
            return config('app.env');
        }]);

        $router->get('testbench-environment-value', ['uses' => function () {
            return Env::get('TESTBENCH_WORKING_PATH');
        }]);
    }

    #[Test]
    public function can_use_dusk()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('hello')
                ->assertSee('hello world');
        });
    }

    #[Test]
    public function can_return_correct_application_environment()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('environment')
                ->assertSee('testing');
        });
    }

    #[Test]
    public function can_use_multiple_browsers()
    {
        $this->browse(function (Browser $browser, Browser $browserTwo) {
            $browser->visit('hello')
                ->assertSee('hello world')
                ->blank();

            $browserTwo->visit('hello')
                ->assertSee('hello world')
                ->blank();
        });
    }

    #[Test]
    public function can_tweak_the_application_within_a_test()
    {
        $this->beforeServingApplication(function ($app, $config) {
            $config->set('new_config_item', 'Fantastic!');
        });

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

    #[Test]
    public function can_use_multiple_browsers_can_persist_testbench_working_path_environment_variables()
    {
        $this->browse(function (Browser $browser, Browser $browserTwo) {
            $browser->visit('testbench-environment-value')
                ->assertSee(package_path())
                ->visit('testbench-environment-value')
                ->assertSee(package_path());

            $browserTwo->visit('testbench-environment-value')
                ->assertSee(package_path())
                ->visit('testbench-environment-value')
                ->assertSee(package_path());
        });

        static::reloadServing();

        $this->browse(function (Browser $browser, Browser $browserTwo) {
            $browser->visit('testbench-environment-value')
                ->assertSee(package_path())
                ->visit('testbench-environment-value')
                ->assertSee(package_path());

            $browserTwo->visit('testbench-environment-value')
                ->assertSee(package_path())
                ->visit('testbench-environment-value')
                ->assertSee(package_path());
        });
    }
}
