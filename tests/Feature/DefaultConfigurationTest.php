<?php

namespace Orchestra\Testbench\Dusk\Tests\Unit;

use Illuminate\Foundation\Auth\User;
use Laravel\Dusk\DuskServiceProvider;
use Orchestra\Testbench\Dusk\TestCase;
use Orchestra\Testbench\Foundation\Env;
use PHPUnit\Framework\Attributes\Test;

class DefaultConfigurationTest extends TestCase
{
    #[Test]
    public function it_populate_expected_testing_config()
    {
        tap($this->app['config']['database.connections.testing'], function ($config) {
            $this->assertTrue(isset($config));
            $this->assertEquals([
                'driver' => 'sqlite',
                'database' => ':memory:',
                'foreign_key_constraints' => false,
            ], $config);
        });
    }

    #[Test]
    public function it_loads_dusk_service_provider()
    {
        $this->assertContains(DuskServiceProvider::class, array_values($this->app['config']['app.providers']));
        $this->assertContains(DuskServiceProvider::class, array_keys($this->app->getLoadedProviders()));
    }

    #[Test]
    public function it_populate_expected_auth_defaults()
    {
        $this->assertSame(User::class, $this->app['config']['auth.providers.users.model']);
    }

    #[Test]
    public function it_populate_expected_cache_defaults()
    {
        $this->assertSame((Env::get('TESTBENCH_PACKAGE_TESTER') === true ? 'database' : 'file'), $this->app['config']['cache.default']);
    }

    #[Test]
    public function it_populate_expected_session_defaults()
    {
        $this->assertSame((Env::get('TESTBENCH_PACKAGE_TESTER') === true ? 'cookie' : 'file'), $this->app['config']['session.driver']);
        $this->assertFalse($this->app['config']['session.expire_on_close']);
    }
}
