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
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->callSilent('package:dusk-purge');

        parent::handle();
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
}
