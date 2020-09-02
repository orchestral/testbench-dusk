<?php

namespace Orchestra\Testbench\Dusk\Tests\Browser;

use Illuminate\Foundation\Auth\User;
use Laravel\Dusk\Browser;
use Orchestra\Testbench\Dusk\TestCase;

class AuthTest extends TestCase
{
    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->loadLaravelMigrations(config('database.default'));
    }

    /** @test */
    public function can_authenticate_user()
    {
        $user = factory(User::class)->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user, 'web')
                ->assertAuthenticatedAs($user, 'web');
        });
    }
}
