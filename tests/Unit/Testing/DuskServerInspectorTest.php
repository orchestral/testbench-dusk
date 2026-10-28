<?php

namespace Orchestra\Testbench\Dusk\Tests\Unit\Testing;

use Orchestra\Testbench\Dusk\DuskServer;
use Orchestra\Testbench\Dusk\Testing\DuskServerInspector;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use RuntimeException;

class DuskServerInspectorTest extends TestCase
{
    /** @var resource|null */
    private $listener = null;

    #[\Override]
    protected function tearDown(): void
    {
        if (\is_resource($this->listener)) {
            fclose($this->listener);
        }

        $this->listener = null;

        parent::tearDown();
    }

    #[Test]
    public function it_exposes_the_inspected_server()
    {
        $server = new DuskServer;

        $this->assertSame($server, (new DuskServerInspector($server))->server);
    }

    #[Test]
    public function it_reports_not_running_when_nothing_is_listening()
    {
        $inspector = new DuskServerInspector(new DuskServer(port: $this->availablePort()));

        $this->assertFalse($inspector->isRunning());
    }

    #[Test]
    public function it_reports_running_when_something_is_listening()
    {
        $port = $this->listenOnAvailablePort();

        $this->assertTrue((new DuskServerInspector(new DuskServer(port: $port)))->isRunning());
    }

    #[Test]
    public function stop_is_a_no_op_when_the_server_is_not_running()
    {
        $server = new class(port: $this->availablePort()) extends DuskServer
        {
            public int $stopCalls = 0;

            #[\Override]
            public function stop(): void
            {
                $this->stopCalls++;
            }
        };

        (new DuskServerInspector($server))->stop();

        $this->assertSame(0, $server->stopCalls);
    }

    #[Test]
    public function it_can_start_and_stop_a_real_server()
    {
        $inspector = new DuskServerInspector(new DuskServer(port: $this->availablePort()));

        $inspector->start();

        try {
            $this->assertTrue($inspector->isRunning());
        } finally {
            $inspector->stop();
        }

        $this->assertFalse($inspector->isRunning());
    }

    #[Test]
    public function start_fails_when_the_server_never_comes_up()
    {
        $server = new class(port: $this->availablePort()) extends DuskServer
        {
            #[\Override]
            public function start(): void
            {
                //
            }
        };

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Waited too long for server to start.');

        (new DuskServerInspector($server))->start();
    }

    #[Test]
    public function stop_fails_when_the_server_never_goes_down()
    {
        $server = new class(port: $this->listenOnAvailablePort()) extends DuskServer
        {
            #[\Override]
            public function stop(): void
            {
                //
            }
        };

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Waited too long for server to stop.');

        (new DuskServerInspector($server))->stop();
    }

    private function availablePort(): int
    {
        $socket = stream_socket_server('tcp://127.0.0.1:0');
        $port = (int) parse_url((string) stream_socket_get_name($socket, false), PHP_URL_PORT);
        fclose($socket);

        return $port;
    }

    private function listenOnAvailablePort(): int
    {
        $this->listener = stream_socket_server('tcp://127.0.0.1:0');

        return (int) parse_url((string) stream_socket_get_name($this->listener, false), PHP_URL_PORT);
    }
}
