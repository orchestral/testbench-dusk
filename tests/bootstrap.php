<?php

include __DIR__.'/../vendor/autoload.php';

// Example usage to set Dusk to run without UI.
// You can enable UI with DuskOptions::withUI();

Orchestra\Testbench\Dusk\Options::withoutUI();
