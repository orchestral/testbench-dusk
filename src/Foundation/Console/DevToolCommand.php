<?php

namespace Orchestra\Testbench\Dusk\Foundation\Console;

use Orchestra\Testbench\Foundation\Console\DevToolCommand as Command;

class DevToolCommand extends Command
{
    /**
     * The environment file name.
     *
     * @var string
     */
    protected $environmentFile = '.env.dusk';
}
