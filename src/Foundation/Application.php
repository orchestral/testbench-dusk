<?php

namespace Orchestra\Testbench\Dusk\Foundation;

use function Orchestra\Testbench\Dusk\default_skeleton_path;

class Application extends \Orchestra\Testbench\Foundation\Application
{
    /**
     * Get Application base path.
     *
     * @return string
     */
    public static function applicationBasePath()
    {
        return $_ENV['APP_BASE_PATH'] ?? default_skeleton_path();
    }
}
