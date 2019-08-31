<?php

namespace Orchestra\Testbench\Dusk\Concerns;

use Closure;
use Opis\Closure\SerializableClosure;
use Orchestra\Testbench\Dusk\DuskServer;

trait CanServeSite
{
    /**
     * The server implementation.
     *
     * @var \Orchestra\Testbench\Dusk\DuskServer
     */
    protected static $server;

    /**
     * Begin serving on a given host and port.
     *
     * @param string $host
     * @param int    $port
     *
     * @throws \Orchestra\Testbench\Dusk\Exceptions\UnableToStartServer
     *
     * @return void
     */
    public static function serve($host = '127.0.0.1', $port = 8000): void
    {
        static::stopServing();

        $server = new DuskServer($host, $port);
        $server->stash(['class' => static::class]);
        $server->start();

        static::$server = $server;
    }

    /**
     * Stop serving on a given host and port. As a safety net, we will
     * shut down all servers if we.
     *
     * @return void
     */
    public static function stopServing(): void
    {
        if (isset(static::$server)) {
            static::$server->stop();
        }
    }

    /**
     * Make tweaks to the application, both inside the test and on the test server.
     *
     * @param \Closure $closure
     *
     * @return void
     */
    public function tweakApplication(Closure $closure): void
    {
        $closure($this->app);

        static::$server->stash([
            'class' => static::class,
            'tweakApplication' => serialize(SerializableClosure::from($closure)),
        ]);
    }

    /**
     * Remove the tweaks to the app from the server. Intended to be
     * called at the end of a test method, since the class's own
     * $app will be rebuilt for each test.
     *
     * It could be added to the tearDown method if used a lot.
     *
     * @return void
     */
    public function removeApplicationTweaks(): void
    {
        static::$server->stash(['class' => static::class]);
    }

    /**
     * Build up a fresh application to serve, intended for use when we want to
     * replicate the Application state during a Dusk test when we start our
     * test server. See the main server file 'server.php'.
     *
     * @param \Orchestra\Testbench\Dusk\DuskServer $server
     *
     * @return \Illuminate\Foundation\Application
     */
    public function getFreshApplicationToServe(DuskServer $server)
    {
        static::$server = $server;

        $this->setUpDuskServer();

        $serializedClosure = static::$server->getStash('tweakApplication');

        if ($serializedClosure) {
            $closure = unserialize($serializedClosure)->getClosure();
            $closure($this->app);
        }

        return $this->app;
    }

    /**
     * Return the current instance of server.
     *
     * @return \Orchestra\Testbench\Dusk\DuskServer|null
     */
    public function getServer()
    {
        return static::$server;
    }

    /**
     * Server specific setup. It may share alot with the main setUp() method, but
     * should exclude things like DB migrations so we don't end up wiping the
     * DB content mid test. Using this method means we can be explicit.
     *
     * @return void
     */
    protected function setUpDuskServer(): void
    {
        parent::setUp();
    }
}
