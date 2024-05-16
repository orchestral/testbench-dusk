<?php

namespace Orchestra\Testbench\Dusk\Foundation\Console;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Laravel\Dusk\Console\DuskCommand as Command;
use Symfony\Component\Console\Attribute\AsCommand;

use function Orchestra\Testbench\package_path;

#[AsCommand(name: 'package:dusk', description: 'Run the package Dusk tests')]
class DuskCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'package:dusk
                {--browse : Open a browser instead of using headless mode}
                {--without-tty : Disable output to TTY}
                {--pest : Run the tests using Pest}';

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

        if (! \defined('TESTBENCH_CORE')) {
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

        return parent::handle();
    }

    /**
     * Get the array of arguments for running PHPUnit.
     *
     * @param  array  $options
     * @return array
     */
    protected function phpunitArguments($options)
    {
        $options = array_values(array_filter($options, static function ($option) {
            return ! Str::startsWith($option, '--env=');
        }));

        $file = Collection::make([
            'phpunit.dusk.xml',
            'phpunit.dusk.xml.dist',
            'phpunit.xml',
            'phpunit.xml.dist',
        ])->map(static fn ($file) => package_path($file))
        ->filter(static fn ($file) => file_exists($file))
        ->first();

        return ! \is_null($file) ? array_merge(['-c', $file], $options) : $options;
    }

    /**
     * Write the Dusk PHPUnit configuration.
     *
     * @return void
     */
    protected function writeConfiguration()
    {
        $file = Collection::make([
            'phpunit.dusk.xml',
            'phpunit.dusk.xml.dist',
            'phpunit.xml',
            'phpunit.xml.dist',
        ])->map(static fn ($file) => package_path($file))
        ->filter(static fn ($file) => file_exists($file))
        ->first();

        if (\is_null($file)) {
            copy((string) realpath(__DIR__.'/../../../stubs/phpunit.xml'), package_path('phpunit.dusk.xml'));

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
        if (! $this->hasPhpUnitConfiguration && file_exists($file = package_path('phpunit.dusk.xml'))) {
            @unlink($file);
        }
    }
}
