<?php

namespace Orchestra\Testbench;

use Symfony\Component\Process\ProcessUtils;
use Symfony\Component\Process\PhpExecutableFinder;

class OrchestraServer
{
    protected $pointer;
    protected $host;
    protected $port;

    public function __construct($host = '127.0.0.1', $port = 8000)
    {
        $this->host = $host;
        $this->port = $port;
    }

    /**
     * Store some temp contents in a file for later use
     *
     * @param $content
     */
    public function stash($content)
    {
        file_put_contents($this->temp(), $content);
    }

    /**
    * Prepare the path of the temp file for a particular server
    */
    protected function temp()
    {
        return __DIR__.'/../tmp/'.$this->host.'__'.$this->port;
    }

    /**
    * Retrieve the contents of the relevant file
    */
    public function getStash()
    {
        return file_get_contents($this->temp());
    }

    // Adapted from the artisan serve command. It means that we are not reliant
    // on Laravel having been booted, so we can use the setUpBeforeClass and
    // tearDownAfterClass static methods to start the server for tests.

    /**
    * Start a php server in a separate process
    */
    public function start()
    {
        $this->stop();
        $this->startServer();
    }

    /**
    * Stop the php server
    */
    public function stop()
    {
        if (! $this->pointer) {
            return;
        }
        proc_terminate($this->pointer);
    }

    protected function startServer()
    {
        $command = sprintf(
            '%s -S %s:%s %s',
            ProcessUtils::escapeArgument((new PhpExecutableFinder)->find(false)),
            $this->host,
            $this->port,
            ProcessUtils::escapeArgument(__DIR__.'/server.php')
        );

        // Execute the command and open a pointer to it.
        // Tuck away the output as it's not relevant
        // for us to show it during our testing
        $this->pointer = proc_open(
            $command,
            [1 => ["pipe", "w"]],
            $pipes,
            $this->laravelPublicPath()
        );
    }

    /**
    * Figure out the path to the laravel application
    * For testbench purposes, this exists in the
    * core package.
    */
    protected function laravelPublicPath()
    {
        $root = realpath(__DIR__.'/../..');

        // Check if we're working on this package. If we are, shimmy to the vendor dir.
        if (! is_dir($root.'/testbench-core')) {
            $root .= '/testbench-dusk/vendor/orchestra/';
        }

        return  $root.'/testbench-core/laravel/public';
    }
}
