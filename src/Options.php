<?php

namespace Orchestra\Testbench\Dusk;

use Facebook\WebDriver\Chrome\ChromeOptions;
use Orchestra\Testbench\Foundation\Env;

/**
 * @api
 */
class Options
{
    /**
     * Store UI setting.
     *
     * @var bool
     */
    public static bool $ui = true;

    /**
     * Headless mode.
     *
     * @var string|null
     */
    public static ?string $headlessMode = null;

    /**
     * Set W3C compliant.
     *
     * @var bool
     */
    public static bool $w3cCompliant = false;

    /**
     * Testbench should provide application server.
     *
     * @var bool
     */
    public static bool $providesApplicationServer = true;

    /**
     * A list of remote web driver arguments.
     *
     * @var array<int, string>
     */
    public static array $arguments = [];

    /**
     * Reset arguments.
     *
     * @return void
     */
    public static function resetArguments(): void
    {
        static::$arguments = [];
    }

    /**
     * Add a browser option.
     *
     * @return static
     */
    public static function addArgument(string $argument)
    {
        if (! static::hasArgument($argument)) {
            array_push(static::$arguments, $argument);
        }

        return new static();
    }

    /**
     * Remove a browser option.
     *
     * @return static
     */
    public static function removeArgument(string $argument)
    {
        if (static::hasArgument($argument)) {
            static::$arguments = array_values(array_filter(static::$arguments, static fn ($option) => $option !== $argument));
        }

        return new static();
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
     * @return static
     */
    public static function withoutUI()
    {
        return static::disableGpu()->headless();
    }

    /**
     * Set to show UI.
     *
     * @return static
     */
    public static function withUI()
    {
        return static::removeArgument('--disable-gpu')
            ->removeArgument('--headless='.(static::$headlessMode ?? 'new'))
            ->removeArgument('--headless');
    }

    /**
     * Return current setting for showing UI.
     */
    public static function hasUI(): bool
    {
        return ! static::hasArgument(sprintf('--headless=%s', (static::$headlessMode ?? 'new'))) &&
            ! static::hasArgument('--headless');
    }

    /**
     * It should uses without UI.
     */
    public static function shouldUsesWithoutUI(): bool
    {
        return Env::get('CI', false) == true;
    }

    /**
     * Run the browser in headless mode.
     *
     * @return static
     */
    public static function headless()
    {
        static::$headlessMode = env('DUSK_HEADLESS_MODE', 'new');

        if (\is_null(static::$headlessMode)) {
            return static::addArgument('--headless');
        }

        return static::addArgument(sprintf('--headless=%s', static::$headlessMode));
    }

    /**
     * Disable the browser using gpu.
     *
     * @return static
     */
    public static function disableGpu()
    {
        return static::addArgument('--disable-gpu');
    }

    /**
     * Disable the sandbox.
     *
     * @return static
     */
    public static function noSandbox()
    {
        return static::addArgument('--no-sandbox');
    }

    /**
     * Disables the use of a zygote process for forking child processes.
     *
     * @return static
     */
    public static function noZygote()
    {
        return static::noSandbox()->addArgument('--no-zygote');
    }

    /**
     * Ignore SSL certificate error messages.
     *
     * @return static
     */
    public static function ignoreSslErrors()
    {
        return static::addArgument('--ignore-certificate-errors');
    }

    /**
     * Set the initial browser window size.
     *
     * @return static
     */
    public static function windowSize(int $width, int $height)
    {
        return static::addArgument(sprintf('--window-size=%d,%d', $width, $height));
    }

    /**
     * Set remote debugging port.
     *
     * @return static
     */
    public static function remoteDebuggingPort(int $port = 9222)
    {
        return static::addArgument(sprintf('--remote-debugging-port=%d', $port));
    }

    /**
     * Set the user agent.
     *
     * @return static
     */
    public static function userAgent(string $useragent)
    {
        return static::addArgument(sprintf('--user-agent=%s', $useragent));
    }

    /**
     * Return the ChromeOptions Object - used when configuring the
     * Facebook Webdriver.
     *
     * @return \Facebook\WebDriver\Chrome\ChromeOptions
     */
    public static function getChromeOptions()
    {
        return tap(new ChromeOptions(), static function ($option) {
            if (static::$w3cCompliant === false) {
                $option->setExperimentalOption('w3c', static::$w3cCompliant);
            }
        })->addArguments(static::$arguments);
    }
}
