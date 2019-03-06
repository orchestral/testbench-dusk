<?php

namespace Orchestra\Testbench\Dusk\Tests\Browser;

use Laravel\Dusk\Browser;
use Illuminate\Foundation\Auth\User;
use Orchestra\Testbench\Dusk\TestCase;

class AuthTest extends TestCase
{
    /**
     * Setup the test environment.
     */
    protected function setUp() : void
    {
        parent::setUp();

        $this->withFactories(__DIR__.'/../factories');
        $this->loadLaravelMigrations(config('database.default'));
    }

    /** @test */
    public function can_authenticate_user()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user, 'web');

            $response = $browser->visit("/_dusk/user/");
            dump($response->driver->getPageSource());

            $browser->assertAuthenticatedAs($user, 'web');
        });
    }
}
