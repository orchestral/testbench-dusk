<?php

namespace Orchestra\Testbench\Dusk\Tests\Browser;

use Orchestra\Testbench\Concerns\WithWorkbench;
use Orchestra\Testbench\Dusk\TestCase;

class WorkbenchTest extends TestCase
{
    use WithWorkbench;

    /** @test */
    public function it_can_browse_the_welcome_page()
    {
        $this->browse(function ($browser) {
            $browser->visit('/')
                ->assertSee('Laravel');
        });
    }

    /** @test */
    public function it_can_browse_routes_from_discovers_routes()
    {
        $this->browse(function ($browser) {
            $browser->visit('/testbench')
                ->assertSee('Alert Component')
                ->assertSee('Notification Component');
        });
    }
}
