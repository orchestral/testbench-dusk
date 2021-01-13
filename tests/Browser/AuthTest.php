<?php

namespace Orchestra\Testbench\Dusk\Tests\Browser;

use Laravel\Dusk\Browser;
use Orchestra\Testbench\Dusk\TestCase;
use Orchestra\Testbench\Factories\UserFactory;

class AuthTest extends TestCase
{
    /**
     * Define database migrations.
     *
     * @return void
     */
    protected function defineDatabaseMigrations()
    {
        $this->loadLaravelMigrations(config('database.default'));
    }

    /** @test */
    public function can_authenticate_user()
    {
        $user = UserFactory::new()->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user, 'web')
                ->assertAuthenticatedAs($user, 'web');
        });
    }
}
