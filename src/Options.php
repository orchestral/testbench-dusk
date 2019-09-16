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
     * Set to hide UI.
     *
     * @return void
     */
    public static function withoutUI()
    {
        static::$ui = false;
    }

    /**
     * Set to show UI.
     *
     * @return void
     */
    public static function withUI()
    {
        static::$ui = true;
    }

    /**
     * Return current setting for showing UI.
     *
     * @return bool
     */
    public static function hasUI()
    {
        return static::$ui;
    }

    /**
     * Return the ChromeOptions Object - used when configuring the
     * Facebook Webdriver.
     *
     * @return \Facebook\WebDriver\Chrome\ChromeOptions
     */
    public static function getChromeOptions()
    {
        return (new ChromeOptions())->addArguments(
            ! static::hasUI() ? ['--disable-gpu', '--headless'] : []
        );
    }
}
