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
     * @return \Closure
     */
    protected function resolveApplicationCallback()
    {
        return function ($app) {
            \call_user_func(parent::resolveApplicationCallback(), $app);

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
