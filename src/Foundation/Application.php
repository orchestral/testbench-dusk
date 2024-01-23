<?php

namespace Orchestra\Testbench\Dusk\Foundation;

use function Illuminate\Filesystem\join_paths;
use function Orchestra\Testbench\Dusk\default_skeleton_path;

class Application extends \Orchestra\Testbench\Foundation\Application
{
    /**
     * Get the default application bootstrap file path (if exists).
     *
     * @internal
     *
     * @param  string  $filename
     * @return string|false
     */
    protected function getDefaultApplicationBootstrapFile(string $filename): string|false
    {
        return realpath(default_skeleton_path(join_paths('bootstrap', $filename)));
    }
}
