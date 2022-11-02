<?php

namespace Orchestra\Testbench\Dusk\Foundation;

use Illuminate\Support\ServiceProvider;

class TestbenchServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if (! file_exists($this->app->databasePath('database.sqlite')) && config('database.default') === 'sqlite') {
            config(['database.default' => 'testing']);
        }

        if (file_exists($this->app->basePath('migrations'))) {
            $this->loadMigrationsFrom($this->app->basePath('migrations'));
        }

        if ($this->app->runningInConsole()) {
            $this->commands([
                Console\DevToolCommand::class,
                Console\DuskCommand::class,
                Console\PurgeCommand::class,
                Console\ServeCommand::class,
            ]);
        }
    }
}
