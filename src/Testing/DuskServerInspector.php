<?php

namespace Orchestra\Testbench\Dusk\Testing;

use Orchestra\Testbench\Dusk\DuskServer;
use RuntimeException;

class DuskServerInspector
{
    /**
     * Construct a new server inspector.
     */
    public function __construct(
        public readonly DuskServer $server,
    ) {}

    /**
     * Start the web-server.
     *
     * @return void
     */
    public function start(): void
    {
        $this->server->start();

        $i = 0;

        while (! $this->isRunning()) {
            sleep(1);
            $i++;

            if ($i >= 5) {
                throw new RuntimeException('Waited too long for server to start.');
            }
        }
    }

    /**
     * Stop the web-server.
     *
     * @return void
     */
    public function stop(): void
    {
        if ($this->isRunning()) {
            $this->server->stop();
        }

        $i = 0;

        while ($this->isRunning()) {
            sleep(1);
            $i++;

            if ($i >= 5) {
                throw new RuntimeException('Waited too long for server to stop.');
            }
        }
    }

    /**
     * Determine if server is up.
     *
     * @return bool
     */
    public function isRunning(): bool
    {
        if ($socket = @fsockopen($this->server->host, $this->server->port, $errorNumber, $errorString, $timeout = 1)) {
            fclose($socket);

            return true;
        }

        return false;
    }
}
