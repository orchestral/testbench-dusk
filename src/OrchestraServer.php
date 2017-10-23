<?php

namespace Orchestra\Testbench;

use Symfony\Component\Process\ProcessUtils;
use Symfony\Component\Process\PhpExecutableFinder;

class OrchestraServer
{
    protected $pointer;
    protected $pipes;
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
        file_put_contents($this->temp(), json_encode($content));
    }

    /**
    * Prepare the path of the temp file for a particular server
    */
    protected function temp()
    {
        return dirname(__DIR__).'/tmp/'.$this->host.'__'.$this->port;
    }

    /**
     * Retrieve the contents of the relevant file
     *
     * @param string $key
     */
    public function getStash($key = null)
    {
        $content = json_decode(file_get_contents($this->temp()), true);

        return $key ? ($content[$key] ?? null) : $content;
    }

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

    /**
     * Start the server. Execute the command and open a
     * pointer to it. Tuck away the output as it's
     * not relevant for us during our testing
     */
    protected function startServer()
    {
        $this->pointer = proc_open(
            $this->prepareCommand(),
            [1 => ['pipe', 'w']],
            $this->pipes,
            $this->laravelPublicPath()
        );
    }

    /**
     * Prepare the command for starting the PHP server
     */
    protected function prepareCommand()
    {
        return sprintf(
            '%s -S %s:%s %s',
            ProcessUtils::escapeArgument((new PhpExecutableFinder)->find(false)),
            $this->host,
            $this->port,
            ProcessUtils::escapeArgument(__DIR__ . '/server.php')
        );
    }


    /**
    * Figure out the path to the laravel application
    * For testbench purposes, this exists in the
    * core package.
    */
    public function laravelPublicPath($root = null)
    {
        $root = dirname(dirname($root ?: __DIR__));

        // Check if we're working on this package. If we are, shimmy to the vendor dir.
        if (! basename(dirname($root)) == 'vendor') {
            $root .= '/testbench-dusk/vendor/orchestra';
        }

        return  $root.'/testbench-core/laravel/public';
    }
}
