<?php

namespace Orchestra\Testbench\Concerns;

use Exception;
use Orchestra\Testbench\ForkedServer;

trait CanServeSite
{
    protected static $forkedServers = [];

    /**
    * Begin serving on a given host and port
    */
    public static function serve($host = '127.0.0.1', $port = 8000)
    {
        $server = new ForkedServer($host, $port);
        $server->stash(static::class);
        $server->start();

        static::$forkedServers[$host.'__'.$port] = $server;
    }

    /**
    * Stop serving on a given host and port. As a safety net, we will
    * shut down all servers if we
    *
    */
    public static function stopServing($host = '127.0.0.1', $port = 8000)
    {
        if (! isset(static::$forkedServers[$host.'__'.$port])) {
            return;
        }

        static::$forkedServers[$host.'__'.$port]->stop();
    }
}
