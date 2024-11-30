<?php

namespace Orchestra\Testbench\Dusk\Foundation\Console;

use Orchestra\Testbench\Foundation\Console\SyncSkeletonCommand as Command;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'package:sync-skeleton', description: 'Sync skeleton folder to be served externally')]
class SyncSkeletonCommand extends Command
{
    //
}
