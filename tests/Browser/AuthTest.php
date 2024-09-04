<?php

namespace Orchestra\Testbench\Dusk\Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Orchestra\Testbench\Concerns\WithLaravelMigrations;
use Orchestra\Testbench\Dusk\TestCase;
use Orchestra\Testbench\Factories\UserFactory;

class AuthTest extends TestCase
{
    use DatabaseMigrations;
    use WithLaravelMigrations;

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
