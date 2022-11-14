<?php

namespace Orchestra\Testbench\Dusk\Foundation;

use Composer\InstalledVersions;
use Illuminate\Foundation\Console\AboutCommand;
use Illuminate\Support\ServiceProvider;

class TestbenchServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $workingPath = defined('TESTBENCH_WORKING_PATH') ? TESTBENCH_WORKING_PATH : null;

        AboutCommand::add('Testbench', fn () => [
            'Dusk Version' => class_exists(InstalledVersions::class) ? InstalledVersions::getPrettyVersion('orchestra/testbench-dusk') : '<fg=yellow;options=bold>-</>',
            'Core Version' => class_exists(InstalledVersions::class) ? InstalledVersions::getPrettyVersion('orchestra/testbench-core') : '<fg=yellow;options=bold>-</>',
            'Skeleton Path' => str_replace($workingPath, '', $this->app->basePath()),
        ]);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if (file_exists($this->app->basePath('migrations'))) {
            $this->loadMigrationsFrom($this->app->basePath('migrations'));
        }

        if ($this->app->runningInConsole()) {
            $this->commands([
                Console\CreateSqliteDbCommand::class,
                Console\DropSqliteDbCommand::class,
                Console\DevToolCommand::class,
                Console\DuskCommand::class,
                Console\PurgeCommand::class,
                Console\ServeCommand::class,
            ]);
        }
    }
}
