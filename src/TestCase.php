<?php

namespace Orchestra\Testbench\Dusk;

use Closure;
use Exception;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Illuminate\Foundation\Application;
use Laravel\Dusk\DuskServiceProvider;
use Orchestra\Testbench\Dusk\Foundation\PackageManifest;
use Orchestra\Testbench\Dusk\Options as DuskOptions;
use Orchestra\Testbench\Foundation\Env;
use Orchestra\Testbench\TestCase as Testbench;
use PHPUnit\Framework\Attributes\BeforeClass;

use function Illuminate\Filesystem\join_paths;
use function Orchestra\Testbench\Dusk\default_skeleton_path;

abstract class TestCase extends Testbench
{
    use Concerns\CanServeSite;
    use Concerns\InteractsWithWebDriverOptions;
    use Concerns\ProvidesBrowser;

    /**
     * The base serve host URL to use while testing the application.
     *
     * @var string
     */
    protected static $baseServeHost = '127.0.0.1';

    /**
     * The base serve port to use while testing the application.
     *
     * @var int
     */
    protected static $baseServePort = 8001;

    /**
     * Keep track of whether we've registered shutdown function.
     *
     * @var bool
     */
    protected static bool $hasRegisteredShutdown = false;

    /**
     * The base server port.
     *
     * @api
     *
     * @return int
     */
    public static function getBaseServePort()
    {
        return Env::get('DUSK_SERVE_PORT') ?? static::$baseServePort;
    }

    /**
     * The base server host.
     *
     * @api
     *
     * @return string
     */
    public static function getBaseServeHost()
    {
        return Env::get('DUSK_SERVE_HOST') ?? static::$baseServeHost;
    }

    /**
     * Get Application's base path.
     *
     * @api
     *
     * @return string
     */
    public static function applicationBasePath()
    {
        return static::applicationBasePathUsingWorkbench() ?? default_skeleton_path();
    }

    /**
     * Get Application's base URL.
     *
     * @api
     *
     * @return string
     */
    public static function applicationBaseUrl()
    {
        return sprintf('http://%s:%d', static::getBaseServeHost(), static::getBaseServePort());
    }

    /**
     * Register the base URL with Dusk.
     *
     * @return void
     */
    #[\Override]
    protected function setUp(): void
    {
        parent::setUp();

        $this->setUpTheBrowserEnvironment();
        $this->registerShutdownFunction();
    }

    /**
     * Determine trait should be ignored from being autoloaded.
     *
     * @internal
     *
     * @param  class-string  $use
     * @return bool
     */
    #[\Override]
    protected function setUpTheTestEnvironmentTraitToBeIgnored(string $use): bool
    {
        return \in_array($use, [
            Concerns\CanServeSite::class,
            Concerns\InteractsWithWebDriverOptions::class,
            Concerns\ProvidesBrowser::class,
            \Laravel\Dusk\Concerns\ProvidesBrowser::class,
            \Laravel\Dusk\Chrome\SupportsChrome::class,
        ]) || parent::setUpTheTestEnvironmentTraitToBeIgnored($use);
    }

    /**
     * Get application providers.
     *
     * @api
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return array<int, class-string>
     */
    #[\Override]
    protected function getApplicationProviders($app)
    {
        $providers = parent::getApplicationProviders($app);

        if (! \in_array(DuskServiceProvider::class, $providers)) {
            array_push($providers, DuskServiceProvider::class);
        }

        return $providers;
    }

    /**
     * Setup parallel testing callback.
     *
     * @internal
     *
     * @return void
     */
    #[\Override]
    protected function setUpParallelTestingCallbacks(): void
    {
        // Not supported at the moment.
    }

    /**
     * Teardown parallel testing callback.
     *
     * @internal
     *
     * @return void
     */
    #[\Override]
    protected function tearDownParallelTestingCallbacks(): void
    {
        // Not supported at the moment.
    }

    /**
     * Make sure we close down any chrome processes when we temrinate early, unlike normal
     * Dusk, we also close down all the server processes - so keeping the chome browser
     * open doesn't help, nor does it help when we're running in headless mode :).
     *
     * @internal
     *
     * @return void
     */
    protected function registerShutdownFunction()
    {
        if (! static::$hasRegisteredShutdown) {
            register_shutdown_function(function () {
                $this->closeAll();
            });

            static::$hasRegisteredShutdown = true;
        }
    }


    /**
     * Get application bootstrap file path (if exists).
     *
     * @api
     *
     * @return string|null
     */
    #[\Override]
    protected function getApplicationBootstrapFile()
    {
        $file = join_paths($this->getBasePath(), 'bootstrap', 'app.php');

        if (default_skeleton_path(join_paths('bootstrap', 'app.php')) !== $file && is_file($file)) {
            return $file;
        }

        return null;
    }

    /**
     * Resolve application implementation.
     *
     * @internal
     *
     * @return \Closure(\Illuminate\Foundation\Application): void
     */
    #[\Override]
    protected function resolveApplicationResolvingCallback(): Closure
    {
        return function ($app) {
            $app->bind(
                'Illuminate\Foundation\Bootstrap\LoadConfiguration',
                Bootstrap\LoadConfiguration::class
            );

            PackageManifest::swap($app, $this);
        };
    }

    /**
     * Create the RemoteWebDriver instance.
     *
     * @api
     *
     * @return \Facebook\WebDriver\Remote\RemoteWebDriver
     */
    protected function driver(): RemoteWebDriver
    {
        if (DuskOptions::shouldUsesWithoutUI()) {
            DuskOptions::withoutUI();
        } elseif ($this->hasHeadlessDisabled()) {
            DuskOptions::withUI();
        }

        return RemoteWebDriver::create(
            Env::get('DUSK_DRIVER_URL') ?? 'http://localhost:9515',
            DesiredCapabilities::chrome()->setCapability(
                ChromeOptions::CAPABILITY,
                DuskOptions::getChromeOptions()
            )
        );
    }

    /**
     * Determine the application's base URL.
     *
     * @api
     *
     * @return string
     */
    protected function baseUrl()
    {
        return static::applicationBaseUrl();
    }

    /**
     * Get a callback that returns the default user to authenticate.
     *
     * @api
     *
     * @return callable
     *
     * @throws \Exception
     */
    protected function user()
    {
        throw new Exception('User resolver has not been set.');
    }

    /**
     * Prepare for Dusk test execution.
     *
     * @internal
     *
     * @return void
     *
     * @codeCoverageIgnore
     */
    #[BeforeClass]
    public static function prepare()
    {
        static::startChromeDriver(['port' => 9515]);
    }

    /**
     * Begin a server for the tests.
     *
     * @internal
     *
     * @return void
     *
     * @codeCoverageIgnore
     */
    #[\Override]
    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        static::startServing();
    }

    /**
     * Clean up the testing environment before the next test case.
     *
     * @internal
     *
     * @return void
     *
     * @codeCoverageIgnore
     */
    #[\Override]
    public static function tearDownAfterClass(): void
    {
        static::stopServing();

        parent::tearDownAfterClass();
    }

    /**
     * Determine whether the Dusk command has disabled headless mode.
     *
     * @api
     *
     * @return bool
     *
     * @codeCoverageIgnore
     */
    protected function hasHeadlessDisabled()
    {
        return Env::get('DUSK_HEADLESS_DISABLED', false) == true;
    }
}
