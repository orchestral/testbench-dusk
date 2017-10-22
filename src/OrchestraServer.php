<?php

namespace Orchestra\Testbench;

use Symfony\Component\Process\ProcessUtils;
use Symfony\Component\Process\PhpExecutableFinder;

class OrchestraServer
{
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
    * Retrieve the contents of the relevant file
    */
    public function getStash()
    {
        return file_get_contents($this->temp());
    }

    /**
    * Start a php server in a separate process
    */
    public function start()
    {
        $this->stop();
        $this->startServer();
    }

    // Adapted from the artisan serve command. It means that we are not reliant
    // on Laravel having been booted, so we can use the setUpBeforeClass and
    // tearDownAfterClass static methods to start the server for tests.
    protected function startServer()
    {
        $command = sprintf(
            '%s -S %s:%s %s > /dev/null 2>&1 &',
            ProcessUtils::escapeArgument((new PhpExecutableFinder)->find(false)),
            $this->host,
            $this->port,
            ProcessUtils::escapeArgument(__DIR__.'/server.php')
        );

        chdir($this->laravelPublicPath());
        passthru($command);
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

    /**
    * Stop the php server
    */
    public function stop()
    {
        posix_kill($this->getServerProcessId(), SIGKILL);
    }

    /**
    * Prepare the path of the temp file for a particular server
    */
    protected function temp()
    {
        return __DIR__.'/../tmp/'.$this->host.'__'.$this->port;
    }

    /**
    * Identify the process id for the server running on this
    * host and port. So we can then shut it down after.
    */
    protected function getServerProcessId()
    {
        $output = null;
        exec('ps | grep -S '.$this->host.':'.$this->port, $output);

        return (int) explode(" ", trim($output[0]))[0];
    }
}
