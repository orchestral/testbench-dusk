<?php

namespace Orchestra\Testbench\Dusk\Foundation;

use function Orchestra\Testbench\Dusk\default_skeleton_path;

class Application extends \Orchestra\Testbench\Foundation\Application
{
    /**
     * Get Application's base path.
     *
     * @return string
     */
    #[\Override]
    public static function applicationBasePath()
    {
        return static::applicationBasePathUsingWorkbench() ?? default_skeleton_path();
    }
}
