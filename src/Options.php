<?php

namespace Orchestra\Testbench\Dusk;

use Facebook\WebDriver\Chrome\ChromeOptions;

class Options
{
    /**
     * Store UI setting.
     *
     * @var bool
     */
    protected static $ui = true;

    /**
     * A list of remote web driver arguments.
     *
     * @var array
     */
    protected static $arguments = [];

    /**
     * Add a browser option.
     *
     * @return void
     */
    public static function addArgument(string $argument)
    {
        if (! static::hasArgument($argument)) {
            \array_push(static::$arguments, $argument);
        }
    }

    /**
     * Remove a browser option.
     *
     * @return void
     */
    public static function removeArgument(string $argument)
    {
        if (static::hasArgument($argument)) {
            static::$arguments = array_values(\array_filter(static::$arguments, function ($option) use ($argument) {
                return $option !== $argument;
            }));
        }
    }


    /**
     * Check has a browser option.
     *
     * @return bool
     */
    public static function hasArgument(string $argument)
    {
        return \in_array($argument, static::$arguments);
    }

    /**
     * Set to hide UI.
     *
     * @return void
     */
    public static function withoutUI()
    {
        static::disableGpu();
        static::headless();
    }

    /**
     * Set to show UI.
     *
     * @return void
     */
    public static function withUI()
    {
        static::removeArgument('--disable-gpu');
        static::removeArgument('--headless');
    }

    /**
     * Return current setting for showing UI.
     *
     * @return bool
     */
    public static function hasUI()
    {
        return ! static::hasArgument('--headless');
    }

    /**
     * Run the browser in headless mode.
     *
     * @return void
     */
    public static function headless()
    {
        static::addArgument('--headless');
    }

    /**
     * Disable the browser using gpu.
     *
     * @return void
     */
    public static function disableGpu()
    {
        static::addArgument('--disable-gpu');
    }

    /**
     * Disable the sandbox.
     *
     * @return void
     */
    public static function noSandbox()
    {
        static::addArgument('--no-sandbox');
    }

    /**
     * Disables the use of a zygote process for forking child processes.
     *
     * @return void
     */
    public static function noZygote()
    {
        static::noSandbox();
        static::addArgument('--no-zygote');
    }

    /**
     * Ignore SSL certificate error messages.
     */
    public static function ignoreSslErrors(): void
    {
        static::addArgument('--ignore-certificate-errors');
    }

    /**
     * Set the initial browser window size.
     *
     * @param $width the browser width in pixels
     * @param $height the browser height in pixels
     *
     * @return void
     */
    public static function windowSize(int $width, int $height)
    {
        static::addArgument('--window-size='.$width.','.$height);
    }

    /**
     * Set the user agent.
     *
     * @param $useragent the user agent to use
     *
     * @return void
     */
    public static function userAgent(string $useragent)
    {
        static::addArgument('--user-agent='.$useragent);
    }

    /**
     * Return the ChromeOptions Object - used when configuring the
     * Facebook Webdriver.
     *
     * @return \Facebook\WebDriver\Chrome\ChromeOptions
     */
    public static function getChromeOptions()
    {
        return (new ChromeOptions())
            ->setExperimentalOption('w3c', false)
            ->addArguments(static::$arguments);
    }
}
