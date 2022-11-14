<?php

namespace Orchestra\Testbench\Dusk\Foundation;

use Composer\InstalledVersions;
use Illuminate\Foundation\Console\AboutCommand;
use Illuminate\Support\ServiceProvider;
use Spatie\Ray\Settings\Settings;

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

        $this->callAfterResolving(Settings::class, function ($settings, $app) {
            /** @var \Illuminate\Contracts\Config\Repository $config */
            $config = $app->make('config');

            if ($config->get('database.default') === 'sqlite' && ! file_exists($config->get('database.connections.sqlite.database'))) {
                $settings->send_queries_to_ray = false;
                $settings->send_duplicate_queries_to_ray = false;
                $settings->send_slow_queries_to_ray = false;
            }
        });
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
