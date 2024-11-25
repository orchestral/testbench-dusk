<?php

namespace Orchestra\Testbench\Dusk\Foundation;

use function Illuminate\Filesystem\join_paths;
use function Orchestra\Testbench\Dusk\default_skeleton_path;

class Application extends \Orchestra\Testbench\Foundation\Application
{
    /**
     * Get Application base path.
     *
     * @return string
     */
    #[\Override]
    public static function applicationBasePath()
    {
        return $_ENV['APP_BASE_PATH'] ?? default_skeleton_path();
    }

    /**
     * Get the default application bootstrap file path (if exists).
     *
     * @internal
     *
     * @param  string  $filename
     * @return string|false
     */
    #[\Override]
    protected function getDefaultApplicationBootstrapFile(string $filename): string|false
    {
        return realpath(default_skeleton_path(join_paths('bootstrap', $filename)));
    }
}
