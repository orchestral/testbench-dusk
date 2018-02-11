<?php

namespace Orchestra\Testbench\Dusk\Tests\Browser;

use Laravel\Dusk\Browser;
use Illuminate\Foundation\Auth\User;
use Orchestra\Testbench\Dusk\TestCase;
use Orchestra\Testbench\Dusk\Concerns\CreateTestingDatabase;

class AuthTest extends TestCase
{
    use CreateTestingDatabase;

    protected function setUp()
    {
        parent::setUp();

        $this->createDatabase(config('database.default'));

        $this->withFactories(__DIR__.'/../factories');
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
