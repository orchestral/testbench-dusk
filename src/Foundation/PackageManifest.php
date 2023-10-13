<?php

namespace Orchestra\Testbench\Dusk\Foundation;

/**
 * @internal
 */
class PackageManifest extends \Orchestra\Testbench\Foundation\PackageManifest
{
    /**
     * List of required packages.
     *
     * @var array<int, string>
     */
    protected array $requiredPackages = [
        'laravel/dusk',
        'spatie/laravel-ray',
    ];
}
