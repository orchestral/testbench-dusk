<?php

namespace Orchestra\Testbench\Dusk\Console;

use Orchestra\Testbench\Console\Commander as Testbench;

class Commander extends Testbench
{
    /**
     * Get base path from trait.
     *
     * @return string
     */
    protected function getBasePathFromTrait()
    {
        return __DIR__.'/../../laravel';
    }
}
