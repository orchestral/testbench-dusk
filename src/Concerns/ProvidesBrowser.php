<?php

namespace Orchestra\Testbench\Dusk\Concerns;

use Konsulting\ProjectRoot;
use Laravel\Dusk\Browser;
use Laravel\Dusk\Chrome\SupportsChrome;
use Laravel\Dusk\Concerns\ProvidesBrowser as Concern;

trait ProvidesBrowser
{
    use Concern,
        SupportsChrome;

    /**
     * Setup the browser environment.
     *
     * @return void
     */
    protected function setUpTheBrowserEnvironment()
    {
        Browser::$baseUrl = $this->baseUrl();

        $this->prepareDirectories();

        Browser::$userResolver = function () {
            return $this->user();
        };
    }

    /**
     * Ensure the directories we need for dusk exist, and set them for the Browser to use.
     *
     * @throws \Exception
     *
     * @return void
     */
    protected function prepareDirectories()
    {
        $tests = $this->resolveBrowserTestsPath();

        foreach (['/screenshots', '/console'] as $dir) {
            if (! \is_dir($tests.$dir)) {
                \mkdir($tests.$dir, 0777, true);
            }
        }

        Browser::$storeScreenshotsAt = $tests.'/screenshots';
        Browser::$storeConsoleLogAt = $tests.'/console';
    }

    /**
     * Figure out where the test directory is, if we're an included package, or the root one.
     *
     * @param string $path
     *
     * @throws \Exception
     *
     * @return string
     */
    protected function resolveBrowserTestsPath($path = __DIR__)
    {
        return ProjectRoot::forPackage('testbench-dusk')->resolve($path).'/tests/Browser';
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
     * @throws \Exception
     *
     * @return callable
     */
    abstract protected function user();
}
