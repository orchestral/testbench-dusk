<?php

namespace Orchestra\Testbench\Dusk;

use Illuminate\Support\LazyCollection;
use Konsulting\ProjectRoot;
use Laravel\Dusk\Browser;

function find_test_directory($path = __DIR__): string
{
    return ProjectRoot::forPackage('testbench-dusk')->resolve($path).'/tests/Browser';
}

function prepare_debug_directories(): void
{
    $path = find_test_directory();

    LazyCollection::make(['screenshots', 'console', 'source'])
        ->map(function ($directory) use ($path) {
            return $path.DIRECTORY_SEPARATOR.$directory;
        })->each(function ($directory) {
            if (! \is_dir($directory)) {
                \mkdir($directory, 0777, true);
            }
        })->each(function ($directory) {
            if (! \is_file("{$directory}/.gitignore")) {
                \copy(\realpath(__DIR__.'/../stubs/gitignore.stub'), "{$directory}/.gitignore");
            }
        });

    Browser::$storeScreenshotsAt = $path.'/screenshots';
    Browser::$storeConsoleLogAt = $path.'/console';
    Browser::$storeSourceAt = $path.'/source';
}
