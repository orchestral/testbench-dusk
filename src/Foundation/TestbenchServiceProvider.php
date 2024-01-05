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
        $workingPath = \defined('TESTBENCH_WORKING_PATH') ? TESTBENCH_WORKING_PATH : null;

        AboutCommand::add('Testbench', fn () => [
            'Core Version' => InstalledVersions::getPrettyVersion('orchestra/testbench-core'),
            'Dusk Version' => InstalledVersions::getPrettyVersion('orchestra/testbench-dusk'),
            'Skeleton Path' => str_replace($workingPath, '', $this->app->basePath()),
            'Version' => InstalledVersions::getPrettyVersion('orchestra/testbench'),
        ]);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                Console\CreateSqliteDbCommand::class,
                Console\DropSqliteDbCommand::class,
                Console\DuskCommand::class,
                Console\PurgeCommand::class,
                Console\PurgeSkeletonCommand::class,
                Console\ServeCommand::class,
            ]);
        }
    }
}
