<?php

namespace Orchestra\Testbench\Dusk\Concerns;

use Closure;
use Laravel\SerializableClosure\SerializableClosure;
use Orchestra\Testbench\Dusk\DuskServer;
use Orchestra\Testbench\Dusk\Foundation\DuskServerInspector;
use Orchestra\Testbench\Dusk\Options;
use ReflectionClass;

use function Orchestra\Sidekick\after_resolving;

trait CanServeSite
{
    /**
     * The server implementation.
     *
     * @var \Orchestra\Testbench\Dusk\DuskServer|null
     */
    protected static ?DuskServer $server = null;

    /**
     * Begin serving on a given host and port.
     *
     * @internal
     *
     * @param  string  $host
     * @param  int  $port
     * @return void
     *
     * @throws \Orchestra\Testbench\Dusk\Exceptions\UnableToStartServer
     */
    public static function serve(string $host = '127.0.0.1', int $port = 8001): void
    {
        static::stopServing();

        if (Options::$providesApplicationServer === false) {
            return;
        }

        $server = new DuskServer($host, $port);

        $server->setLaravel(basePath: static::applicationBasePath(), baseUrl: static::applicationBaseUrl());
        $server->stash(['class' => static::servingTestClass()]);

        $server->start();

        static::$server = $server;
    }

    /**
     * Resolve the test class the server process should instantiate.
     *
     * Classes generated at runtime (e.g. by Pest using `eval()`) do not exist
     * in the server process, so the nearest ancestor declared in a file is used.
     *
     * @internal
     *
     * @return class-string<\Orchestra\Testbench\Dusk\TestCase>
     */
    protected static function servingTestClass(): string
    {
        $reflection = new ReflectionClass(static::class);

        while (
            ($reflection->getFileName() === false || str_contains($reflection->getFileName(), "eval()'d code"))
            && ($parent = $reflection->getParentClass()) !== false
        ) {
            $reflection = $parent;
        }

        /** @var class-string<\Orchestra\Testbench\Dusk\TestCase> */
        return $reflection->getName();
    }

    /**
     * Start serving on a given host and port.
     *
     * @api
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
     * @api
     *
     * @return void
     */
    public static function stopServing(): void
    {
        if (isset(static::$server)) {
            (new DuskServerInspector(static::$server))->stop();
        }
    }

    /**
     * Reload serving on a given host and port.
     *
     * @api
     *
     * @return void
     */
    public static function reloadServing(): void
    {
        static::flushDuskServer();
        static::startServing();
    }

    /**
     * Configure application before served via Dusk.
     *
     * @api
     *
     * @param  (\Closure(\Illuminate\Foundation\Application, \Illuminate\Contracts\Config\Repository):(void))|string  $closure
     * @return void
     */
    public function beforeServingApplication(Closure|string $closure): void
    {
        if (Options::$providesApplicationServer === false) {
            return;
        }

        /** @var \Illuminate\Foundation\Application $app */
        $app = $this->app;

        after_resolving($app, 'config', function ($config, $app) use ($closure) {
            /**
             * @var \Illuminate\Foundation\Application $app
             * @var \Illuminate\Contracts\Config\Repository $config
             */
            \is_string($closure) && method_exists($this, $closure)
                ? \call_user_func([$this, $closure], $app, $config) // @phpstan-ignore argument.type
                : value($closure, $app, $config); // @phpstan-ignore argument.type
        });

        static::$server?->stash([
            'class' => static::servingTestClass(),
            'tweakApplication' => \is_string($closure)
                ? serialize($closure)
                : serialize(SerializableClosure::unsigned($closure)),
        ]);

        $this->beforeApplicationDestroyed(function () {
            $this->afterServingApplication();
        });
    }

    /**
     * Reset application after served via Dusk.
     *
     * @return void
     */
    public function afterServingApplication(): void
    {
        static::$server?->stash(['class' => static::servingTestClass()]);
    }

    /**
     * Make tweaks to the application, both inside the test and on the test server.
     *
     * @api
     *
     * @param  \Closure(\Illuminate\Foundation\Application, \Illuminate\Contracts\Config\Repository):void  $closure
     * @return void
     *
     * @deprecated 7.55.0 Use `beforeServingApplication()` instead.
     *
     * @codeCoverageIgnore
     */
    #[\Deprecated('Use `beforeServingApplication()` instead', since: '7.55.0')]
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
     * @internal
     *
     * @return void
     *
     * @deprecated 7.55.0 Use `afterServingApplication()` instead.
     *
     * @codeCoverageIgnore
     */
    #[\Deprecated('Use `afterServingApplication()` instead', since: '7.55.0')]
    public function removeApplicationTweaks(): void
    {
        $this->afterServingApplication();
    }

    /**
     * Build up a fresh application to serve, intended for use when we want to
     * replicate the Application state during a Dusk test when we start our
     * test server. See the main server file 'server.php'.
     *
     * @internal
     *
     * @param  \Orchestra\Testbench\Dusk\DuskServer  $server
     * @return \Illuminate\Foundation\Application
     *
     * @codeCoverageIgnore
     */
    public function createServingApplicationForDuskServer(DuskServer $server)
    {
        static::$server = $server;

        $this->setUpApplicationForDuskServer();

        /** @var \Illuminate\Foundation\Application $app */
        $app = $this->app;

        $serializedClosure = unserialize($server->getStash('tweakApplication'));

        if ($serializedClosure) {
            /** @var (\Closure(\Illuminate\Foundation\Application, \Illuminate\Contracts\Config\Repository):(void))|string $closure */
            $closure = \is_string($serializedClosure) ? $serializedClosure : $serializedClosure->getClosure();

            after_resolving($app, 'config', function ($config, $app) use ($closure) {
                /**
                 * @var \Illuminate\Foundation\Application $app
                 * @var \Illuminate\Contracts\Config\Repository $config
                 */
                \is_string($closure) && method_exists($this, $closure)
                    ? \call_user_func([$this, $closure], $app, $config) // @phpstan-ignore argument.type
                    : value($closure, $app, $config); // @phpstan-ignore argument.type
            });
        }

        return $app;
    }

    /**
     * Build up a fresh application to serve, intended for use when we want to
     * replicate the Application state during a Dusk test when we start our
     * test server. See the main server file 'server.php'.
     *
     * @internal
     *
     * @param  \Orchestra\Testbench\Dusk\DuskServer  $server
     * @return \Illuminate\Foundation\Application
     *
     * @deprecated
     *
     * @codeCoverageIgnore
     */
    #[\Deprecated('Use `createServingApplicationForDuskServer()` instead', since: '6.40.0')]
    public function getFreshApplicationToServe(DuskServer $server)
    {
        return $this->createServingApplicationForDuskServer($server);
    }

    /**
     * Return the current instance of server.
     *
     * @api
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
     * @api
     *
     * @return void
     *
     * @codeCoverageIgnore
     */
    #[\Deprecated('Use `setUpApplicationForDuskServer()` instead', since: '11.7.0')]
    protected function setUpDuskServer(): void
    {
        $this->setUpApplicationForDuskServer();
    }

    /**
     * Server specific setup. It may share alot with the main setUp() method, but
     * should exclude things like DB migrations so we don't end up wiping the
     * DB content mid test. Using this method means we can be explicit.
     *
     * @api
     *
     * @return void
     *
     * @codeCoverageIgnore
     */
    protected function setUpApplicationForDuskServer(): void
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
     * The base server port.
     *
     * @return int
     */
    abstract public static function getBaseServePort();

    /**
     * Get base server host.
     *
     * @return string
     */
    abstract public static function getBaseServeHost();

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
