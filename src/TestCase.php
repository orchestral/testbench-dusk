<?php

namespace Orchestra\Testbench\Dusk;

use Exception;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Illuminate\Foundation\Application;
use Orchestra\Testbench\Dusk\Options as DuskOptions;
use Orchestra\Testbench\TestCase as Testbench;

abstract class TestCase extends Testbench
{
    use Concerns\CanServeSite,
        Concerns\ProvidesBrowser;

    /**
     * The base serve host URL to use while testing the application.
     *
     * @var string
     */
    protected static $baseServeHost = '127.0.0.1';

    /**
     * The base serve port to use while testing the application.
     *
     * @var int
     */
    protected static $baseServePort = 8000;

    /**
     * Keep track of whether we've registered shutdown function.
     *
     * @var bool
     */
    protected static $hasRegisteredShutdown = false;

    /**
     * Determine the application's base URL.
     *
     * @var string
     *
     * @return string
     */
    public static function baseServeUrl()
    {
        return \sprintf('http://%s:%d', static::$baseServeHost, static::$baseServePort);
    }

    /**
     * Register the base URL with Dusk.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->setUpTheBrowserEnvironment();
        $this->registerShutdownFunction();
    }

    /**
     * Make sure we close down any chrome processes when we temrinate early, unlike normal
     * Dusk, we also close down all the server processes - so keeping the chome browser
     * open doesn't help, nor does it help when we're running in headless mode :).
     *
     * @return void
     */
    protected function registerShutdownFunction()
    {
        if (! static::$hasRegisteredShutdown) {
            \register_shutdown_function(function () {
                $this->closeAll();
            });

            static::$hasRegisteredShutdown = true;
        }
    }

    /**
     * Get base path.
     *
     * @return string
     */
    protected function getBasePath()
    {
        return __DIR__.'/../laravel';
    }

    /**
     * Resolve application implementation.
     *
     * @return \Illuminate\Foundation\Application
     */
    protected function resolveApplication()
    {
        return \tap(new Application($this->getBasePath()), static function ($app) {
            $app->bind(
                'Illuminate\Foundation\Bootstrap\LoadConfiguration',
                Bootstrap\LoadConfiguration::class
            );
        });
    }

    /**
     * Create the RemoteWebDriver instance.
     *
     * @return \Facebook\WebDriver\Remote\RemoteWebDriver
     */
    protected function driver(): RemoteWebDriver
    {
        if (DuskOptions::shouldUsesWithoutUI()) {
            DuskOptions::withoutUI();
        }

        return RemoteWebDriver::create(
            'http://localhost:9515',
            DesiredCapabilities::chrome()->setCapability(
                ChromeOptions::CAPABILITY,
                DuskOptions::getChromeOptions()
            )
        );
    }

    /**
     * Determine the application's base URL.
     *
     * @var string
     *
     * @return string
     */
    protected function baseUrl()
    {
        return \sprintf('http://%s:%d', static::$baseServeHost, static::$baseServePort);
    }

    /**
     * Get a callback that returns the default user to authenticate.
     *
     * @throws \Exception
     *
     * @return callable
     */
    protected function user()
    {
        throw new Exception('User resolver has not been set.');
    }

    /**
     * Prepare for Dusk test execution.
     *
     * @beforeClass
     *
     * @return void
     */
    public static function prepare()
    {
        static::startChromeDriver(['port' => 9515]);
    }

    /**
     * Begin a server for the tests.
     *
     * @return void
     */
    public static function setUpBeforeClass(): void
    {
        static::serve(static::$baseServeHost, static::$baseServePort);
    }

    /**
     * Kill our server.
     *
     * @return void
     */
    public static function tearDownAfterClass(): void
    {
        static::stopServing();
    }
}
