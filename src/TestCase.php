<?php

namespace Orchestra\Testbench\Dusk;

use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;

abstract class TestCase extends Testing
{
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
     * Create the RemoteWebDriver instance.
     *
     * @return \Facebook\WebDriver\Remote\RemoteWebDriver
     */
    protected function driver(): RemoteWebDriver
    {
        $options = (new ChromeOptions())->addArguments([
            '--headless',
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
