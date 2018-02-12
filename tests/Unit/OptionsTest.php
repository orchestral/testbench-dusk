<?php

namespace Orchestra\Testbench\Dusk\Tests\Unit;

use Orchestra\Testbench\Dusk\Options;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;

class OptionsTest extends PHPUnitTestCase
{
    /** @test * */
    public function it_returns_chrome_options_without_ui()
    {
        Options::withoutUI();

        $this->assertEquals(
            ['--disable-gpu', '--headless'],
            Options::getChromeOptions()->toArray()['args']
        );
    }

    /** @test * */
    public function it_returns_chrome_options_with_ui()
    {
        Options::withUI();

        $this->assertNotContains('args', Options::getChromeOptions()->toArray());
    }

    /** @test * */
    public function it_tells_us_if_we_want_ui()
    {
        Options::withUI();

        $this->assertTrue(Options::hasUI());

        Options::withoutUI();

        $this->assertFalse(Options::hasUI());
    }
}
