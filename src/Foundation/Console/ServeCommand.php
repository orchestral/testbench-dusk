<?php

namespace Orchestra\Testbench\Dusk\Foundation\Console;

use Orchestra\Testbench\Foundation\Console\ServeCommand as Command;

class ServeCommand extends Command
{
    /**
     * The environment file name.
     *
     * @var string
     */
    protected $environmentFile = '.env.dusk';
}
