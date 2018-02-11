<?php

namespace Orchestra\Testbench\Dusk\Concerns;

use InvalidArgumentException;

trait CreateTestingDatabase
{
    /**
     * Create testing database. (Only support sqlite),
     *
     * @param  string|null  $connection
     * @return void
     *
     * @throws \InvalidArgumentException
     */
    protected function createDatabase($connection = null)
    {
        $connection = is_null($connection) ? $this->app['config']->get('database.default') : $connection;

        $current = $this->app['config']->get("database.connections.{$connection}");
        $engine = isset($current['driver']) ? $current['driver'] : 'mysql';

        if (! in_array($engine, ['sqlite'])) {
            throw new InvalidArgumentException("Unable to create database using [{$engine}]");
        }

        if ($engine == 'sqlite' && ! file_exists($current['database'])) {
            copy($this->app->databasePath('/database.sqlite.example'), $current['database']);
        }
    }
}
