<?php

namespace Orchestra\Testbench\Concerns;

use Orchestra\Testbench\ForkedServer;

trait CanServeSite
{
    protected $forkedServers = [];

    public function serve($port = 8000)
    {
        $this->forkedServers[$port] = new ForkedServer($port);
        $this->forkedServers[$port]->stash(static::class);
        $this->forkedServers[$port]->start();
    }

    public function stopServing($port = 8000)
    {
        if (isset($this->forkedServers[$port])) {
            $this->forkedServers[$port]->stop();
            return;
        }

        foreach (array_keys($this->forkedServers) as $p) {
            $this->stopServing($p);
        }
        throw new Exception("No server on port {$port}. We stopped them all.");
    }
}
