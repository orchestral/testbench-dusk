<?php

namespace Orchestra\Testbench\Dusk\Bootstrap;

use Illuminate\Contracts\Config\Repository as RepositoryContract;
use Illuminate\Contracts\Foundation\Application;

use function Orchestra\Testbench\Dusk\default_skeleton_path;

/**
 * @internal
 */
final class LoadConfiguration extends \Orchestra\Testbench\Bootstrap\LoadConfiguration
{
    /** {@inheritDoc} */
    #[\Override]
    protected function configureDefaultDatabaseConnection(RepositoryContract $config): void
    {
        //
    }

    /** {@inheritDoc} */
    #[\Override]
    protected function getConfigurationPath(Application $app): string
    {
        return is_dir($app->basePath('config'))
            ? $app->basePath('config')
            : default_skeleton_path('config');
    }
}
