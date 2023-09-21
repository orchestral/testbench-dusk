<?php

namespace Orchestra\Testbench\Dusk\Tests\Browser;

use Orchestra\Testbench\Concerns\WithWorkbench;
use Orchestra\Testbench\Dusk\TestCase;

class WorkbenchTest extends TestCase
{
    use WithWorkbench;

    /** @test */
    public function it_can_use_faker()
    {
        $this->browse(function ($browser) {
            $browser->visit('welcome')
                ->assertSee('Documentation');
        });
    }
}
