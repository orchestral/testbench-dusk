<?php

namespace Orchestra\Testbench\Dusk\Tests\Unit;

use Orchestra\Testbench\Dusk\Options;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;

class OptionsTest extends PHPUnitTestCase
{
    /** {@inheritDoc} */
    #[\Override]
    protected function tearDown(): void
    {
        Options::resetArguments();
    }

    #[Test]
    public function it_returns_chrome_options_without_ui()
    {
        Options::withoutUI();

        $this->assertEquals(
            ['--disable-gpu', '--headless=new'],
            Options::getChromeOptions()->toArray()['args']
        );
    }

    #[Test]
    public function it_returns_chrome_options_with_ui()
    {
        Options::withUI();

        $this->assertNotContains('args', Options::getChromeOptions()->toArray());
    }

    #[Test]
    public function it_tells_us_if_we_want_ui()
    {
        Options::withoutUI();

        $this->assertFalse(Options::hasUI());

        Options::withUI();

        $this->assertTrue(Options::hasUI());
    }

    #[Test]
    public function it_can_use_no_zygote_argument()
    {
        Options::noZygote();

        $this->assertEquals(
            ['--no-sandbox', '--no-zygote'],
            Options::getChromeOptions()->toArray()['args']
        );
    }

    #[Test]
    public function it_can_use_ignore_ssl_errors_argument()
    {
        Options::ignoreSslErrors();

        $this->assertEquals(
            ['--ignore-certificate-errors'],
            Options::getChromeOptions()->toArray()['args']
        );
    }

    #[Test]
    public function it_can_use_window_size_argument()
    {
        Options::windowSize(2048, 1080);

        $this->assertEquals(
            ['--window-size=2048,1080'],
            Options::getChromeOptions()->toArray()['args']
        );
    }

    #[Test]
    public function it_can_use_remote_debugging_port_argument()
    {
        Options::remoteDebuggingPort(9095);

        $this->assertEquals(
            ['--remote-debugging-port=9095'],
            Options::getChromeOptions()->toArray()['args']
        );
    }

    #[Test]
    public function it_can_use_user_agent_argument()
    {
        Options::userAgent('Dusk');

        $this->assertEquals(
            ['--user-agent=Dusk'],
            Options::getChromeOptions()->toArray()['args']
        );
    }
}
