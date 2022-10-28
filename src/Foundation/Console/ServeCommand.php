<?php

namespace Orchestra\Testbench\Dusk\Foundation\Console;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Collection;
use Orchestra\Testbench\Foundation\Console\ServeCommand as Command;

class ServeCommand extends Command
{
    /**
     * Copy the ".env" file.
     *
     * @param  \Illuminate\Filesystem\Filesystem  $filesystem
     * @param  string  $workingPath
     * @return void
     */
    protected function copyTestbenchDotEnvFile(Filesystem $filesystem, string $workingPath): void
    {
        $configurationFile = Collection::make([
            '.env.dusk',
            '.env.dusk.example',
            '.env.dusk.dist',
        ])->map(fn ($file) => "{$workingPath}/{$file}")
        ->filter(fn ($file) => $filesystem->exists($file))
        ->first();

        if (! is_null($configurationFile)) {
            $filesystem->copy($configurationFile, $this->laravel->basePath('.env'));
        }
    }
}
