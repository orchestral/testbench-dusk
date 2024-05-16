<?php

namespace Orchestra\Testbench\Dusk\Console;

use Orchestra\Testbench\Console\Commander as Testbench;
use Orchestra\Testbench\Dusk\Foundation\TestbenchServiceProvider;

use function Orchestra\Testbench\Dusk\default_skeleton_path;

class Commander extends Testbench
{
    /**
     * Resolve application implementation.
     *
     * @return \Closure(\Illuminate\Foundation\Application):void
     */
    protected function resolveApplicationCallback()
    {
        return static function ($app) {
            $app->register(TestbenchServiceProvider::class);
        };
    }

    /**
     * Get base path from trait.
     *
     * @return string
     */
    protected function getBasePathFromTrait()
    {
        return default_skeleton_path();
    }
}
