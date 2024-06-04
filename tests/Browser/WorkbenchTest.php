<?php

namespace Orchestra\Testbench\Dusk\Tests\Browser;

use Illuminate\Contracts\Http\Kernel as HttpKernel;
use Orchestra\Testbench\Attributes\RequiresLaravel;
use Orchestra\Testbench\Attributes\WithEnv;
use Orchestra\Testbench\Concerns\WithWorkbench;
use Orchestra\Testbench\Dusk\TestCase;
use Orchestra\Workbench\Http\Middleware\CatchDefaultRoute;
use PHPUnit\Framework\Attributes\Test;

#[WithEnv('APP_DEBUG', true)]
class WorkbenchTest extends TestCase
{
    use WithWorkbench;

    #[Test]
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

    #[Test]
    public function it_can_browse_the_welcome_page()
    {
        $this->browse(static fn ($browser) => $browser
            ->visit('/')
            ->assertSee('Laravel')
        );
    }

    #[Test]
    public function it_can_browse_routes_from_discovers_routes()
    {
        $this->browse(static fn ($browser) => $browser
            ->visit('/testbench')
            ->assertSee('Alert Component')
            ->assertSee('Notification Component')
        );
    }

    #[Test]
    #[RequiresLaravel('>=11.9.2')]
    public function it_can_render_exception_page()
    {
        $this->browse(static fn ($browser) => $browser
            ->visit('failed')
            ->waitForText('Internal Server Error')
            ->assertSee('RuntimeException')
            ->assertSee('Bad route!')
        );
    }
}
