<?php

namespace Orchestra\Testbench\Dusk;

use Exception;
use Illuminate\Foundation\Application;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Orchestra\Testbench\TestCase as Foundation;
use Facebook\WebDriver\Remote\DesiredCapabilities;

abstract class TestCase extends Foundation
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
        return tap(new Application($this->getBasePath()), function ($app) {
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
    protected function driver()
    {
        $options = (new ChromeOptions())->addArguments([
            '--disable-gpu',
        ]);

        return RemoteWebDriver::create(
            'http://localhost:9515',
            DesiredCapabilities::chrome()->setCapability(
                ChromeOptions::CAPABILITY,
                $options
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
        return sprintf('http://%s:%d', static::$baseServeHost, static::$baseServePort);
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
        static::startChromeDriver();
    }

    /**
     * Begin a server for the tests.
     */
    public static function setUpBeforeClass()
    {
        static::serve(static::$baseServeHost, static::$baseServePort);
    }

    /**
     * Kill our server.
     */
    public static function tearDownAfterClass()
    {
        static::stopServing();
    }
}
