<?php

namespace Orchestra\Testbench\Dusk\Concerns;

use Closure;
use Illuminate\Queue\SerializableClosureFactory;
use Opis\Closure\SerializableClosure;
use Orchestra\Testbench\Dusk\DuskServer;
use Orchestra\Testbench\Dusk\Options;

use function Orchestra\Testbench\after_resolving;

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

        $basePath = (new static())->getBasePath();

        $server = new DuskServer($host, $port);
        $server->setPublicPath("{$basePath}/public");
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
     * @param  \Closure(\Illuminate\Foundation\Application):void  $closure
     * @return void
     */
    public function beforeServingApplication(Closure $closure): void
    {
        after_resolving($this->app, 'config', function ($config, $app) use ($closure) {
            $closure($app, $config);
        });

        static::$server->stash([
            'class' => static::class,
            'tweakApplication' => serialize(
                class_exists(SerializableClosureFactory::class)
                    ? SerializableClosureFactory::make($closure)
                    : new SerializableClosure($closure)
            ),
        ]);

        $this->beforeApplicationDestroyed(function () {
            $this->removeApplicationTweaks();
        });
    }

    /**
     * Make tweaks to the application, both inside the test and on the test server.
     *
     * @param  \Closure(\Illuminate\Foundation\Application):void  $closure
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
     */
    public function getFreshApplicationToServe(DuskServer $server)
    {
        static::$server = $server;

        $this->setUpDuskServer();

        $serializedClosure = static::$server->getStash('tweakApplication');

        if ($serializedClosure) {
            $closure = unserialize($serializedClosure)->getClosure();

            after_resolving($this->app, 'config', function ($config, $app) use ($closure) {
                $closure($app, $config);
            });
        }

        ray($this->app['config']['app.providers']);

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
        ray(static::cachedUsesForTestCase());
        ray(static::cachedConfigurationForWorkbench());

        if (! $this->app) {
            $this->refreshApplication();
        }
    }

    /**
     * Get base path.
     *
     * @return string
     */
    abstract protected function getBasePath();
}
