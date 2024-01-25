<?php

namespace Orchestra\Testbench\Dusk\Tests\Browser;

use Illuminate\Contracts\Http\Kernel as HttpKernel;
use Orchestra\Testbench\Concerns\WithWorkbench;
use Orchestra\Testbench\Dusk\TestCase;
use Orchestra\Workbench\Http\Middleware\CatchDefaultRoute;

class WorkbenchTest extends TestCase
{
    use WithWorkbench;

    /** @test */
    public function it_can_browse_the_default_page()
    {
        $this->beforeServingApplication(static function ($app) {
            $app->make(HttpKernel::class)->pushMiddleware(CatchDefaultRoute::class);
        });

        $this->browse(static fn ($browser) => $browser
            ->visit('/')
            ->assertSee('Laravel')
        );
    }

    /** @test */
    public function it_can_browse_the_welcome_page()
    {
        $this->browse(static fn ($browser) => $browser
            ->visit('/welcome')
            ->assertSee('Laravel')
        );
    }
}
