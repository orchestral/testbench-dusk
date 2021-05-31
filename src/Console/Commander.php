<?php

namespace Orchestra\Testbench\Dusk\Console;

use Orchestra\Testbench\Console\Commander as Testbench;
use Orchestra\Testbench\Dusk\Foundation\TestbenchServiceProvider;

class Commander extends Testbench
{
    /**
     * Resolve application implementation.
     *
     * @return \Illuminate\Foundation\Application
     */
    protected function resolveApplication()
    {
        return \tap(parent::resolveApplication(), static function ($app) {
            $app->register(TestbenchServiceProvider::class);
        });
    }

    /**
     * Get base path from trait.
     *
     * @return string
     */
    protected function getBasePathFromTrait()
    {
        return __DIR__.'/../../laravel';
    }
}
