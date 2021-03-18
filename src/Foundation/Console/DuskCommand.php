<?php

namespace Orchestra\Testbench\Dusk\Foundation\Console;

use Illuminate\Support\Str;
use Laravel\Dusk\Console\DuskCommand as Command;
use Symfony\Component\Finder\Finder;

class DuskCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'package:dusk
                {--browse : Open a browser instead of using headless mode}
                {--without-tty : Disable output to TTY}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run the package Dusk tests';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();

        if (! defined('TESTBENCH_WORKING_PATH')) {
            $this->setHidden(true);
        }
    }

    /**
     * Get the array of arguments for running PHPUnit.
     *
     * @param  array  $options
     * @return array
     */
    protected function phpunitArguments($options)
    {
        $options = array_values(array_filter($options, function ($option) {
            return ! Str::startsWith($option, '--env=');
        }));

        if (! file_exists($file = TESTBENCH_WORKING_PATH.'/phpunit.dusk.xml')) {
            $file = TESTBENCH_WORKING_PATH.'/phpunit.dusk.xml.dist';
        }

        return array_merge(['-c', $file], $options);
    }

    /**
     * Purge the failure screenshots.
     *
     * @return void
     */
    protected function purgeScreenshots()
    {
        $this->purgeDebuggingFiles(
            TESTBENCH_WORKING_PATH.'/tests/Browser/screenshots', 'failure-*'
        );
    }

    /**
     * Purge the console logs.
     *
     * @return void
     */
    protected function purgeConsoleLogs()
    {
        $this->purgeDebuggingFiles(
            TESTBENCH_WORKING_PATH.'/tests/Browser/console', '*.log'
        );
    }

    /**
     * Purge the source logs.
     *
     * @return void
     */
    protected function purgeSourceLogs()
    {
        $this->purgeDebuggingFiles(
            TESTBENCH_WORKING_PATH.'/tests/Browser/source', '*.txt'
        );
    }

    /**
     * Write the Dusk PHPUnit configuration.
     *
     * @return void
     */
    protected function writeConfiguration()
    {
        if (! file_exists($file = TESTBENCH_WORKING_PATH.'/phpunit.dusk.xml') &&
            ! file_exists(TESTBENCH_WORKING_PATH.'/phpunit.dusk.xml.dist')) {
            copy(realpath(__DIR__.'/../../../stubs/phpunit.xml'), $file);

            return;
        }

        $this->hasPhpUnitConfiguration = true;
    }

    /**
     * Remove the Dusk PHPUnit configuration.
     *
     * @return void
     */
    protected function removeConfiguration()
    {
        if (! $this->hasPhpUnitConfiguration && file_exists($file = TESTBENCH_WORKING_PATH.'/phpunit.dusk.xml')) {
            unlink($file);
        }
    }

    /**
     * Purge existing logs.
     */
    protected function purgeDebuggingFiles(string $path, string $patterns): void
    {
        if (! is_dir($path)) {
            return;
        }

        foreach (Finder::create()->files()->in($path)->name($patterns) as $file) {
            @unlink($file->getRealPath());
        }
    }
}
