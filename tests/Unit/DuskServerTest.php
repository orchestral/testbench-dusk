<?php

namespace Orchestra\Testbench\Dusk\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Orchestra\Testbench\Dusk\DuskServer;
use Orchestra\Testbench\Dusk\Exceptions\UnableToStartServer;

class DuskServerTest extends TestCase
{
    /** @test */
    public function it_provides_the_laravel_public_directory()
    {
        $this->assertEquals(
            realpath(__DIR__.'/../../laravel/public'),
            (new DuskServer())->laravelPublicPath()
        );
    }

    /** @test */
    public function it_provides_the_laravel_public_directory_from_custom_location()
    {
        $this->assertEquals(
            '/dir/project/laravel/public',
            (new DuskServer())->laravelPublicPath('/dir/project/laravel/public')
        );
    }

    /** @test */
    public function it_fails_when_there_is_a_server_on_the_host_and_port_already()
    {
        try {
            $a = new DuskServer();
            $b = new DuskServer();

            $a->start();
            $this->waitForServerToStart();

            $b->start();
        } catch (UnableToStartServer $e) {
            $a->stop();

            $this->waitForServerToStop();
            $this->assertTrue(true, 'New server was not created with the same host and port');

            return;
        }

        $a->stop();
        $b->stop();

        $this->waitForServerToStop();

        $this->fail('A server existed but we tried to set a new one up anyway');
    }

    /** @test */
    public function an_early_exit_does_not_leave_an_orphan_server()
    {
        switch ($pid = pcntl_fork()) {
            case -1:
                $this->fail('Process fork failed when testing for an orphan server');
                break;
            case 0:
                // @child
                // We have everything from the script so far available
                // So create a server and exit (to simluate a dd() or similar in a test)
                // Once complete, the parent can check for the orpahn server.
                (new DuskServer())->start();
                $this->waitForServerToStart();
                exit();
                break;
            default:
                // @parent
                pcntl_waitpid($pid, $status);
                try {
                    (new DuskServer())->start();
                    $this->assertTrue(true, 'We did not end up with an orphan server');
                } catch (UnableToStartServer $e) {
                    $this->fail('There was an orphan server. You\'ll need to remove it manually.');
                }
                break;
        }
    }

    protected function waitForServerToStart()
    {
        $i = 0;

        while (! $this->isServerUp()) {
            sleep(1);
            $i++;

            if ($i >= 30) {
                throw new \Exception('Waited too long for server to start.');
            }
        }
    }

    protected function waitForServerToStop()
    {
        $i = 0;

        while ($this->isServerUp()) {
            sleep(1);
            $i++;

            if ($i >= 30) {
                throw new \Exception('Waited too long for server to stop.');
            }
        }
    }

    protected function isServerUp()
    {
        if ($socket = @fsockopen('127.0.0.1', 8000, $errorNumber = 0, $errorString = '', $timeout = 1)) {
            fclose($socket);

            return true;
        }

        return false;
    }
}
