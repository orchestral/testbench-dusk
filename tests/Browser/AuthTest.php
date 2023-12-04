<?php

namespace Orchestra\Testbench\Dusk\Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Orchestra\Testbench\Attributes\WithMigration;
use Orchestra\Testbench\Dusk\TestCase;
use Orchestra\Testbench\Factories\UserFactory;
use PHPUnit\Framework\Attributes\Test;

class AuthTest extends TestCase
{
    use DatabaseMigrations;

    #[Test]
    #[WithMigration]
    public function can_authenticate_user()
    {
        $user = UserFactory::new()->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user, 'web')
                ->assertAuthenticatedAs($user, 'web');
        });
    }
}
