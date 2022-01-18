<?php

namespace Orchestra\Testbench\Dusk\Foundation;

class PackageManifest extends \Orchestra\Testbench\Foundation\PackageManifest
{
    /**
     * List of required packages.
     *
     * @var array<int, string>
     */
    protected $requiredPackages = [
        'laravel/dusk',
        'spatie/laravel-ray',
    ];
}
