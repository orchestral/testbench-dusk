<?php

namespace Orchestra\Testbench\Dusk;

use Exception;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Orchestra\Testbench\TestCase as Foundation;
use Facebook\WebDriver\Remote\DesiredCapabilities;

abstract class TestCase extends Foundation
{
    use Concerns\CanServeSite,
        Concerns\ProvidesBrowser;

    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://127.0.0.1:8000';

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
     * Create the RemoteWebDriver instance.
     *
     * @return \Facebook\WebDriver\Remote\RemoteWebDriver
     */
    protected function driver()
    {
        $options = (new ChromeOptions())->addArguments([
            '--disable-gpu',
            '--headless',
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
     * @return \Illuminate\Config\Repository|mixed
     */
    protected function baseUrl()
    {
        return $this->baseUrl;
    }

    /**
     * Get a callback that returns the default user to authenticate.
     *
     * @throws \Exception
     *
     * @return void
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
        static::serve();
    }

    /**
     * Kill our server.
     */
    public static function tearDownAfterClass()
    {
        static::stopServing();
    }
}
