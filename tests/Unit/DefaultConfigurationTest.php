<?php

namespace Orchestra\Testbench\Dusk\Tests\Unit;

use Illuminate\Foundation\Auth\User;
use Laravel\Dusk\DuskServiceProvider;
use Orchestra\Testbench\Dusk\TestCase as TestbenchDuskTestCase;

class DefaultConfigurationTest extends TestbenchDuskTestCase
{
    /** @test */
    public function it_loads_dusk_service_provider()
    {
        $this->assertContains(DuskServiceProvider::class, array_values($this->app['config']['app.providers']));
        $this->assertContains(DuskServiceProvider::class, array_keys($this->app->getLoadedProviders()));
    }

    /** @test */
    public function it_populate_expected_auth_defaults()
    {
        $this->assertSame(User::class, $this->app['config']['auth.providers.users.model']);
    }

    /** @test */
    public function it_populate_expected_cache_defaults()
    {
        $this->assertSame('file', $this->app['config']['cache.default']);
    }

    /** @test */
    public function it_populate_expected_session_defaults()
    {
        $this->assertSame('file', $this->app['config']['session.driver']);
        $this->assertFalse($this->app['config']['session.expire_on_close']);
    }
}
