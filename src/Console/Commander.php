<?php

namespace Orchestra\Testbench\Dusk\Console;

use Orchestra\Testbench\Dusk\Foundation\Application as Testbench;
use Orchestra\Testbench\Dusk\Foundation\TestbenchServiceProvider;

class Commander extends \Orchestra\Testbench\Console\Commander
{
    /**
     * The environment file name.
     *
     * @var string
     */
    protected string $environmentFile = '.env.dusk';

    /**
     * The testbench implementation class.
     *
     * @var class-string<\Orchestra\Testbench\Foundation\Application>
     */
    protected static string $testbench = Testbench::class;

    /**
     * List of providers.
     *
     * @var array<int, class-string<\Illuminate\Support\ServiceProvider>>
     */
    protected array $providers = [
        TestbenchServiceProvider::class,
    ];
}
