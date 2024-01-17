<?php

namespace Orchestra\Testbench\Dusk\Console;

use Orchestra\Testbench\Console\Commander as Testbench;
use Orchestra\Testbench\Dusk\Foundation\TestbenchServiceProvider;

use function Orchestra\Testbench\Dusk\default_skeleton_path;

class Commander extends Testbench
{
    /**
     * The environment file name.
     *
     * @var string
     */
    protected string $environmentFile = '.env.dusk';

    /**
     * List of providers.
     *
     * @var array<int, class-string<\Illuminate\Support\ServiceProvider>>
     */
    protected array $providers = [
        TestbenchServiceProvider::class,
    ];

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
}
