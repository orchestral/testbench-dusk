<?php

namespace Orchestra\Testbench;

class ForkedServer
{
    protected $pid;
    protected $port;

    public function __construct($port)
    {
        $this->port = $port;
    }

    public function stash($content)
    {
        file_put_contents($this->temp(), $content);
    }

    public function getStash()
    {
        return file_get_contents($this->temp());
    }

    public function start()
    {
        $this->stop();

        $this->pid = pcntl_fork();

        if ($this->pid == -1) {
            throw new \Exception('Failed creating serve process');
        }

        if ($this->pid) {
            return;
        }

        \Artisan::call('orchestra:serve', ['--port' => $this->port]);
    }

    public function stop()
    {
        if (! $this->pid) {
            return;
        }

        // Kill php server spawned by artisan
        posix_kill($this->getArtisanServerPid(), SIGKILL);

        posix_kill($this->pid, SIGKILL);
        pcntl_waitpid($this->pid, $status);

        $this->pid = null;
    }

    protected function temp()
    {
        return __DIR__.'/../tmp/' . $this->port;
    }

    protected function getArtisanServerPid()
    {
        $output = null;
        exec('ps | grep -S 127.0.0.1:'.$this->port, $output);

        return explode(" ", $output[0])[0];
    }
}
