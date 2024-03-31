<?php

namespace Orchestra\Testbench\Dusk;

use Exception;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Laravel\Dusk\DuskServiceProvider;
use Orchestra\Testbench\Dusk\Foundation\PackageManifest;
use Orchestra\Testbench\Dusk\Options as DuskOptions;
use Orchestra\Testbench\Foundation\Env;
use Orchestra\Testbench\TestCase as Testbench;

use function Illuminate\Filesystem\join_paths;

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
    #[\Override]
    public static function applicationBasePath()
    {
        return static::applicationBasePathUsingWorkbench() ?? default_skeleton_path();
    }

    /**
     * Get the default application bootstrap file path (if exists).
     *
     * @internal
     *
     * @param  string  $filename
     * @return string|false
     */
    #[\Override]
    protected function getDefaultApplicationBootstrapFile(string $filename): string|false
    {
        return realpath(default_skeleton_path(join_paths('bootstrap', $filename)));
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
        return Env::get('DUSK_SERVE_URL') ?? sprintf('http://%s:%d', static::getBaseServeHost(), static::getBaseServePort());
    }

    /**
     * Setup the test environment.
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
     * Teardown the test environment.
     *
     * @return void
     */
    #[\Override]
    protected function tearDown(): void
    {
        parent::tearDown();

        if (static::$server) {
            static::$server->clearOutput();
        }
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
     * Resolve application resolving callback.
     *
     * @internal
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    private function resolveApplicationResolvingCallback($app): void
    {
        $app->bind(
            'Illuminate\Foundation\Bootstrap\LoadConfiguration',
            Bootstrap\LoadConfiguration::class
        );

        PackageManifest::swap($app, $this);
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
     * Setup the test environment.
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
        static::setUpBeforeClassForInteractsWithWebDriverOptions();

        if (! isset($_ENV['DUSK_DRIVER_URL'])) {
            static::defineChromeDriver();
        }

        parent::setUpBeforeClass();
        static::startServing();
    }

    /**
     * Define the ChromeDriver.
     *
     * @api     
     *
     * @return void
     *
     * @codeCoverageIgnore
     */
    protected static function defineChromeDriver(): void
    {
        static::startChromeDriver(['port' => 9515]);
    }

    /**
     * Teardown the test environment.
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
        static::tearDownAfterClassProvidesBrowser();
        static::tearDownAfterClassCanServeSite();

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
