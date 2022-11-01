<?php

namespace Orchestra\Testbench\Dusk\Console;

use Orchestra\Testbench\Console\Commander as Testbench;
use Orchestra\Testbench\Dusk\Foundation\TestbenchServiceProvider;

class Commander extends Testbench
{
    /**
     * The environment file name.
     *
     * @var string
     */
    protected $environmentFile = '.env.dusk';

    /**
     * Resolve application implementation.
     *
     * @return \Closure(\Illuminate\Foundation\Application):void
     */
    protected function resolveApplicationCallback()
    {
        return function ($app) {
            $app->register(TestbenchServiceProvider::class);
        };
    }

    /**
     * Get Application base path.
     *
     * @return string
     */
    public static function applicationBasePath()
    {
        return $_ENV['APP_BASE_PATH'] ?? realpath(__DIR__.'/../../laravel');
    }
}
