<?php

namespace Orchestra\Testbench\Dusk\Concerns;

use Closure;
use Laravel\Dusk\Browser;
use Laravel\Dusk\Chrome\SupportsChrome;
use Laravel\Dusk\Concerns\ProvidesBrowser as Concern;
use Orchestra\Testbench\Concerns\HandlesAttributes;
use Orchestra\Testbench\Dusk\Attributes\BeforeServing;
use Orchestra\Testbench\Dusk\Attributes\RestartServer;

use function Orchestra\Testbench\Dusk\find_test_directory;
use function Orchestra\Testbench\Dusk\prepare_debug_directories;

trait ProvidesBrowser
{
    use Concern,
        SupportsChrome;

    /**
     * Setup the browser environment.
     *
     * @return void
     *
     * @throws \Exception
     */
    protected function setUpTheBrowserEnvironment()
    {
        Browser::$baseUrl = $this->baseUrl();

        $this->prepareDirectories();

        Browser::$userResolver = function () {
            return $this->user();
        };

        if (static::usesTestingConcern(HandlesAttributes::class)) {
            $this->parseTestMethodAttributes($this->app, RestartServer::class);
            $this->parseTestMethodAttributes($this->app, BeforeServing::class)
                ->take(1)
                ->each(function ($callback) {
                    $this->beforeServingApplication($callback);
                });
        }
    }

    /**
     * Ensure the directories we need for dusk exist, and set them for the Browser to use.
     *
     * @return void
     *
     * @throws \Exception
     */
    protected function prepareDirectories()
    {
        prepare_debug_directories();
    }

    /**
     * Figure out where the test directory is, if we're an included package, or the root one.
     *
     * @param  string  $path
     * @return string
     *
     * @throws \Exception
     */
    protected function resolveBrowserTestsPath($path = __DIR__)
    {
        return find_test_directory($path);
    }

    /**
     * Determine the application's base URL.
     *
     * @var string
     */
    abstract protected function baseUrl();

    /**
     * Get a callback that returns the default user to authenticate.
     *
     * @return callable
     *
     * @throws \Exception
     */
    abstract protected function user();
}
