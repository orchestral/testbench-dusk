<?php

include __DIR__.'/../vendor/autoload.php';

// Example usage to set Dusk to run without UI.
// You can enable UI with DuskOptions::withUI();

if (isset($_SERVER['CI']) || isset($_ENV['CI'])) {
    Orchestra\Testbench\Dusk\Options::withoutUI();
} else {
    Orchestra\Testbench\Dusk\Options::withUI();
}
