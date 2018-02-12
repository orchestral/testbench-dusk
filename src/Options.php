<?php

namespace Orchestra\Testbench\Dusk;

use Facebook\WebDriver\Chrome\ChromeOptions;

class Options
{
    static $ui = true;

    public static function withoutUI()
    {
        static::$ui = false;
    }

    public static function withUI()
    {
        static::$ui = true;
    }

    public static function hasUI()
    {
        return static::$ui;
    }

    /**
     * Return the ChromeOptions Object - used when configuring the
     * Facebook Webdriver
     *
     * @return \Facebook\WebDriver\Chrome\ChromeOptions
     */
    public static function getChromeOptions()
    {
        return (new ChromeOptions())->addArguments(array_merge(
            [],
            ! static::hasUI() ? ['--disable-gpu', '--headless'] : []
        ));
    }
}
