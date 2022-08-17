<?php

namespace Orchestra\Testbench\Dusk;

use Orchestra\Testbench\Dusk\Exceptions\UnableToStartServer;
use Symfony\Component\Process\PhpExecutableFinder;
use Symfony\Component\Process\Process;

class DuskServer
{
    /**
     * Process pointer reference.
     *
     * @var Process
     */
    protected $process;

    /**
     * Array of file pointers.
     *
     * @var array
     */
    protected $pipes;

    /**
     * Server host.
     *
     * @var string
     */
    protected $host;

    /**
     * Server port.
     *
     * @var int
     */
    protected $port;

    /**
     * Laravel public working path.
     *
     * @var string|null
     */
    protected $laravelPublicPath;

    /**
     * Construct a new server.
     *
     * @param  string  $host
     * @param  int  $port
     */
    public function __construct($host = '127.0.0.1', $port = 8001)
    {
        $this->host = $host;
        $this->port = $port;
    }

    /**
     * Set Laravel working path.
     *
     * @param  string|null  $publicPath
     * @return void
     */
    public function setPublicPath(?string $publicPath = null): void
    {
        $this->laravelPublicPath = $publicPath;
    }

    /**
     * Store some temp contents in a file for later use.
     *
     * @param  mixed  $content
     * @return void
     */
    public function stash($content): void
    {
        file_put_contents($this->temp(), json_encode($content));
    }

    /**
     * Prepare the path of the temp file for a particular server.
     *
     * @return string
     */
    protected function temp(): string
    {
        return \dirname(__DIR__).'/tmp/'.$this->host.'__'.$this->port;
    }

    /**
     * Retrieve the contents of the relevant file.
     *
     * @param  string|null  $key
     * @return mixed
     */
    public function getStash(?string $key = null)
    {
        $content = json_decode(file_get_contents($this->temp()), true);

        return $key ? (isset($content[$key]) ? $content[$key] : null) : $content;
    }

    /**
     * Start a php server in a separate process.
     *
     * @return void
     *
     * @throws \Orchestra\Testbench\Dusk\Exceptions\UnableToStartServer
     */
    public function start(): void
    {
        $this->stop();
        $this->startServer();

        // We register the below, so if php is exited early, the child
        // process for the server is closed down, rather than left
        // hanging around for the user to close themselves.
        register_shutdown_function(function () {
            $this->stop();
        });
    }

    /**
     * Stop the php server.
     *
     * @return void
     */
    public function stop(): void
    {
        if (! $this->process) {
            return;
        }

        $this->process->stop();
    }

    /**
     * Start the server. Execute the command and open a
     * pointer to it. Tuck away the output as it's
     * not relevant for us during our testing.
     *
     * @return void
     *
     * @throws \Orchestra\Testbench\Dusk\Exceptions\UnableToStartServer
     */
    protected function startServer(): void
    {
        $this->guardServerStarting();

        $this->process = Process::fromShellCommandline($this->prepareCommand());
        $this->process->setWorkingDirectory($this->laravelPublicPath());
        $this->process->start();
    }

    /**
     * Verify that there isn't an existing server on the host and port
     * that we want to use.  Sometimes a server can be left oped when
     * PHP drops out, or the user may have another service running.
     *
     * @throws \Orchestra\Testbench\Dusk\Exceptions\UnableToStartServer
     */
    protected function guardServerStarting()
    {
        $socket = rescue(function () {
            $errorNumber = 0;
            $errorString = '';
            $timeout = 1;

            return @fsockopen($this->host, $this->port, $errorNumber, $errorString, $timeout);
        }, null, false);

        if ($socket) {
            fclose($socket);
            throw new UnableToStartServer($this->host.':'.$this->port);
        }
    }

    /**
     * Prepare the command for starting the PHP server.
     *
     * @return string
     */
    protected function prepareCommand(): string
    {
        return sprintf(
            (($this->isWindows() ? '' : 'exec ').'%s -S %s:%s %s'),
            (new PhpExecutableFinder())->find(false),
            $this->host,
            $this->port,
            '"'.__DIR__.'/server.php'.'"'
        );
    }

    /**
     * Figure out the path to the laravel application
     * For testbench purposes, this exists in the
     * core package.
     *
     * @param  string|null  $root
     * @return string
     */
    public function laravelPublicPath(): string
    {
        return $this->laravelPublicPath ?: realpath(__DIR__.'/../laravel/public');
    }

    /**
     * Get the current process.
     *
     * @return \Symfony\Component\Process\Process|null
     */
    public function getProcess()
    {
        return $this->process;
    }

    /**
     * Check if current OS is Windows.
     *
     * @return bool
     */
    protected function isWindows()
    {
        return strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';
    }
}
