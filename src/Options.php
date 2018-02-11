<?php

namespace Orchestra\Testbench\Dusk;

use Facebook\WebDriver\Chrome\ChromeOptions;

class Options
{
    static $headless = true;

    public static function headless()
    {
        static::$headless = true;
    }

    public static function notHeadless()
    {
        static::$headless = false;
    }

    public static function isHeadless()
    {
        return static::$headless;
    }

    public static function getChromeOptions()
    {
        return (new ChromeOptions())->addArguments(array_merge(
            ['--disable-gpu'],
            static::isHeadless() ? ['--headless'] : []
        ));
    }
}
