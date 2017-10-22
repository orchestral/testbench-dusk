<?php

namespace Orchestra\Testbench\Concerns;

use Orchestra\Testbench\OrchestraServer;

trait CanServeSite
{
    protected static $servers = [];

    /**
     * Begin serving on a given host and port
     *
     * @param string $host
     * @param int    $port
     */
    public static function serve($host = '127.0.0.1', $port = 8000)
    {
        $server = new OrchestraServer($host, $port);
        $server->stash(static::class);
        $server->start();

        static::$servers[$host.'__'.$port] = $server;
    }

    /**
     * Stop serving on a given host and port. As a safety net, we will
     * shut down all servers if we
     *
     * @param string $host
     * @param int    $port
     */
    public static function stopServing($host = '127.0.0.1', $port = 8000)
    {
        if (! isset(static::$servers[$host.'__'.$port])) {
            return;
        }

        static::$servers[$host.'__'.$port]->stop();
    }
}
