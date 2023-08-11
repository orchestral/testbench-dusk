<?php

namespace Orchestra\Testbench\Dusk\Tests\Browser;

use Faker\Generator;
use Illuminate\Foundation\Testing\WithFaker;
use Orchestra\Testbench\Dusk\TestCase;

class WithFakerTest extends TestCase
{
    use WithFaker;

    /** @test */
    public function it_can_use_faker()
    {
        $this->browse(function ($browser) {
            $this->assertInstanceOf(Generator::class, $this->faker);
        });
    }
}
