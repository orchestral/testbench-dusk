<?php

namespace Orchestra\Testbench\Dusk\Concerns;

use Closure;
use Illuminate\Queue\SerializableClosureFactory;
use Opis\Closure\SerializableClosure;
use Orchestra\Testbench\Dusk\DuskServer;
use Orchestra\Testbench\Dusk\Options;

use function Orchestra\Testbench\after_resolving;

/**
 * @internal
 */
trait CanServeSite
{
    /**
     * The server implementation.
     *
     * @var \Orchestra\Testbench\Dusk\DuskServer|null
     */
    protected static $server;

    /**
     * Begin serving on a given host and port.
     *
     * @param  string  $host
     * @param  int  $port
     * @return void
     *
     * @throws \Orchestra\Testbench\Dusk\Exceptions\UnableToStartServer
     */
    public static function serve($host = '127.0.0.1', $port = 8001): void
    {
        static::stopServing();

        if (Options::$providesApplicationServer !== true) {
            return;
        }

        $server = new DuskServer($host, $port);
        $server->setLaravel(static::applicationBasePath(), static::applicationBaseUrl());
        $server->stash(['class' => static::class]);
        $server->start();

        static::$server = $server;
    }

    /**
     * Start serving on a given host and port.
     *
     * @return void
     */
    public static function startServing(): void
    {
        static::serve(static::getBaseServeHost(), static::getBaseServePort());
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
     * Reload serving on a given host and port.
     *
     * @return void
     */
    public static function reloadServing(): void
    {
        static::flushDuskServer();
        static::startServing();
    }

    /**
     * Make tweaks to the application, both inside the test and on the test server.
     *
     * @param  (\Closure(\Illuminate\Foundation\Application, \Illuminate\Contracts\Config\Repository):(void))|string  $closure
     * @return void
     */
    public function beforeServingApplication($closure): void
    {
        /** @var \Illuminate\Foundation\Application $app */
        $app = $this->app;

        after_resolving($app, 'config', function ($config, $app) use ($closure) {
            \is_string($closure) && method_exists($this, $closure)
                ? $this->{$closure}($app, $config)
                : value($closure, $app, $config);
        });

        static::$server->stash([
            'class' => static::class,
            'tweakApplication' => \is_string($closure)
                ? serialize($closure)
                : serialize(SerializableClosureFactory::make($closure)),
        ]);

        $this->beforeApplicationDestroyed(function () {
            $this->removeApplicationTweaks();
        });
    }

    /**
     * Make tweaks to the application, both inside the test and on the test server.
     *
     * @param  \Closure(\Illuminate\Foundation\Application, \Illuminate\Contracts\Config\Repository):(void)  $closure
     * @return void
     */
    public function tweakApplication(Closure $closure): void
    {
        $this->beforeServingApplication($closure);
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
     * @param  \Orchestra\Testbench\Dusk\DuskServer  $server
     * @return \Illuminate\Foundation\Application
     *
     * @codeCoverageIgnore
     */
    public function createServingApplicationForDuskServer(DuskServer $server)
    {
        static::$server = $server;

        $this->setUpDuskServer();

        $serializedClosure = unserialize(static::$server->getStash('tweakApplication'));

        if ($serializedClosure) {
            $closure = \is_string($serializedClosure) ? $serializedClosure : $serializedClosure->getClosure();

            after_resolving($this->app, 'config', function ($config, $app) use ($closure) {
                \is_string($closure) && method_exists($this, $closure)
                    ? $this->{$closure}($app, $config)
                    : $closure($app, $config);
            });
        }

        return $this->app;
    }

    /**
     * Build up a fresh application to serve, intended for use when we want to
     * replicate the Application state during a Dusk test when we start our
     * test server. See the main server file 'server.php'.
     *
     * @param  \Orchestra\Testbench\Dusk\DuskServer  $server
     * @return \Illuminate\Foundation\Application
     *
     * @deprecated
     *
     * @codeCoverageIgnore
     */
    public function getFreshApplicationToServe(DuskServer $server)
    {
        return $this->createServingApplicationForDuskServer($server);
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
     *
     * @codeCoverageIgnore
     */
    protected function setUpDuskServer(): void
    {
        static::cachedUsesForTestCase();
        static::cachedConfigurationForWorkbench();

        if (! $this->app) {
            $this->refreshApplication();
        }
    }

    /**
     * Stop the dusk server and flush any reference.
     *
     * @return void
     */
    protected static function flushDuskServer(): void
    {
        static::stopServing();

        static::$server = null;
    }

    /**
     * Teardown the test environment.
     *
     * @return void
     *
     * @codeCoverageIgnore
     */
    protected static function tearDownAfterClassCanServeSite(): void
    {
        static::flushDuskServer();
    }

    /**
     * Get Application's base path.
     *
     * @return string
     */
    abstract public static function applicationBasePath();

    /**
     * Get Application's base URL.
     *
     *
     * @return string
     */
    abstract public static function applicationBaseUrl();
}
