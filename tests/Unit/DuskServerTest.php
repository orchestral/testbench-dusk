<?php

namespace Orchestra\Testbench\Dusk\Tests\Unit;

use Orchestra\Testbench\Dusk\DuskServer;
use Orchestra\Testbench\Dusk\Exceptions\UnableToStartServer;
use Orchestra\Testbench\Dusk\Tests\Concerns\InteractsWithServer;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

use function Orchestra\Testbench\bail;

class DuskServerTest extends TestCase
{
    use InteractsWithServer;

    #[Test]
    public function it_provides_the_laravel_public_directory()
    {
        $this->assertEquals(
            realpath(__DIR__.'/../../laravel'),
            (new DuskServer)->basePath()
        );
    }

    #[Test]
    public function it_provides_the_laravel_public_directory_from_custom_location()
    {
        $server = new DuskServer;
        $server->setLaravel(basePath: '/dir/project/laravel');

        $this->assertEquals(
            '/dir/project/laravel',
            $server->basePath()
        );
    }

    #[Test]
    public function it_fails_when_there_is_a_server_on_the_host_and_port_already()
    {
        try {
            $a = new DuskServer;
            $b = new DuskServer;

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

    #[Test]
    public function it_disables_process_output_so_the_server_pipe_cannot_fill()
    {
        $server = new DuskServer;

        $server->start();
        $this->waitForServerToStart();

        try {
            $process = $server->getProcess();

            $this->assertNotNull($process);
            $this->assertTrue(
                $process->isOutputDisabled(),
                'Server process must discard stdout/stderr so php -S cannot block when the pipe fills'
            );

            // clearOutput must remain safe when output is disabled (called from tearDown).
            $server->clearOutput();
            $this->assertTrue($this->isServerUp());
        } finally {
            $server->stop();
            $this->waitForServerToStop();
        }
    }

    #[Test]
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
                (new DuskServer)->start();
                $this->waitForServerToStart();
                bail($this);
                break;
            default:
                // @parent
                pcntl_waitpid($pid, $status);
                try {
                    (new DuskServer)->start();
                    $this->assertTrue(true, 'We did not end up with an orphan server');
                } catch (UnableToStartServer $e) {
                    $this->fail('There was an orphan server. You\'ll need to remove it manually.');
                }
                break;
        }
    }
}
