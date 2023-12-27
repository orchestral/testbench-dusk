<?php

namespace Orchestra\Testbench\Dusk;

use Illuminate\Support\LazyCollection;
use Konsulting\ProjectRoot;
use Laravel\Dusk\Browser;

/**
 * Find test directory.
 *
 * @param  string  $path
 */
function find_test_directory($path = __DIR__): string
{
    return ProjectRoot::forPackage('testbench-dusk')->resolve($path).'/tests/Browser';
}

/**
 * Prepare debug direcotories.
 */
function prepare_debug_directories(): void
{
    if (\defined('TESTBENCH_DIRECTORY_STUBBED')) {
        return;
    }

    $path = find_test_directory();

    LazyCollection::make(['screenshots', 'console', 'source'])
        ->map(static function ($directory) use ($path) {
            return $path.DIRECTORY_SEPARATOR.$directory;
        })->each(static function ($directory) {
            if (! is_dir($directory)) {
                mkdir($directory, 0777, true);
            }
        })->each(static function ($directory) {
            if (! is_file("{$directory}/.gitignore")) {
                copy(realpath(__DIR__.'/../stubs/gitignore.stub'), "{$directory}/.gitignore");
            }
        });

    Browser::$storeScreenshotsAt = $path.'/screenshots';
    Browser::$storeConsoleLogAt = $path.'/console';
    Browser::$storeSourceAt = $path.'/source';

    \define('TESTBENCH_DIRECTORY_STUBBED', true);
}
