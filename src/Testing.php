<?php

namespace Orchestra\Testbench\Dusk;

use Closure;
use Exception;
use Orchestra\Testbench\TestCase;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;

abstract class Testing extends TestCase
{
    use Concerns\CanServeSite,
        Concerns\ProvidesBrowser;

    /**
     * Register the base URL with Dusk.
     *
     * @return void
     */
    protected function setUp()
    {
        parent::setUp();

        $this->setUpTheBrowserEnvironment();
    }

    /**
     * Register an "after class" tear down callback.
     *
     * @param  \Closure $callback
     *
     * @return void
     */
    public static function afterClass(Closure $callback)
    {
        static::$afterClassCallbacks[] = $callback;
    }

    /**
     * Create the RemoteWebDriver instance.
     *
     * @return \Facebook\WebDriver\Remote\RemoteWebDriver
     */
    protected function driver(): RemoteWebDriver
    {
        return RemoteWebDriver::create(
            'http://localhost:9515', DesiredCapabilities::chrome()
        );
    }

    /**
     * Determine the application's base URL.
     *
     * @var string
     */
    protected function baseUrl(): string
    {
        return config('app.url');
    }

    /**
     * Get a callback that returns the default user to authenticate.
     *
     * @throws \Exception
     *
     * @return \Closure
     */
    protected function user()
    {
        throw new Exception('User resolver has not been set.');
    }
}
