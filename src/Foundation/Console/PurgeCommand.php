<?php

namespace Orchestra\Testbench\Dusk\Foundation\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;

class PurgeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'package:dusk-purge';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Purge the package debugging files for Dusk';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        if (! \defined('TESTBENCH_WORKING_PATH')) {
            $this->setHidden(true);
        }
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->purgeDebuggingFiles(
            'tests/Browser/screenshots', 'failure-*'
        );

        $this->purgeDebuggingFiles(
            'tests/Browser/console', '*.log'
        );

        $this->purgeDebuggingFiles(
            'tests/Browser/source', '*.txt'
        );

        return self::SUCCESS;
    }

    /**
     * Purge existing logs.
     */
    protected function purgeDebuggingFiles(string $relativePath, string $patterns): void
    {
        $path = TESTBENCH_WORKING_PATH."/{$relativePath}";

        if (! is_dir($path)) {
            $this->warn(
                "Unable to purge missing directory [{$relativePath}].", OutputInterface::VERBOSITY_DEBUG
            );

            return;
        }

        foreach (Finder::create()->files()->in($path)->name($patterns) as $file) {
            @unlink($file->getRealPath());
        }

        $this->info("Purged \"{$patterns}\" from [{$relativePath}] path.");
    }
}
