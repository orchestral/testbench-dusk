<?php

namespace Orchestra\Testbench\Dusk\Tests\Unit\Concerns;

use Orchestra\Testbench\Dusk\Concerns\CanServeSite;
use Orchestra\Testbench\Dusk\Testing\DuskServerInspector;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

use function Orchestra\Testbench\Dusk\default_skeleton_path;

class CanServeSiteTest extends TestCase
{
    #[Test]
    public function it_starts_and_stops_a_server()
    {
        $dummy = new CanServeSiteDummy;

        $dummy::serve('127.0.0.1', 8001);

        $server = $dummy->getServer();
        $this->assertNotNull($server);
        $inspector = new DuskServerInspector($server);

        $process = $server->getProcess();
        $this->assertNotNull($process);
        $this->assertFalse($process->isTerminated());

        // It can take a little time to get up and running.
        $inspector->start();
        $this->assertTrue($inspector->isRunning());

        $dummy::stopServing();
        $inspector->stop($inspector);

        $this->assertTrue($process->isTerminated());
        $this->assertFalse($inspector->isRunning());
    }

    #[Test]
    public function it_stops_an_existing_server_and_starts_a_new_one_with_consecutive_serve_requests()
    {
        $dummy = new CanServeSiteDummy;

        $dummy::serve('127.0.0.1', 8001);

        $duskServerOne = $dummy->getServer();
        $this->assertNotNull($duskServerOne);
        $processOne = $duskServerOne->getProcess();
        $this->assertNotNull($processOne);
        // we don't bother waiting since that is tested in 'it_starts_and_stops_a_server'

        $dummy::serve('127.0.0.1', 8001);

        $duskServerTwo = $dummy->getServer();
        $this->assertNotNull($duskServerTwo);
        $processTwo = $duskServerTwo->getProcess();
        $this->assertNotNull($processTwo);

        $this->assertNotSame($duskServerOne, $duskServerTwo);
        $this->assertTrue($processOne->isTerminated());
        $this->assertFalse($processTwo->isTerminated());

        $dummy::stopServing();
    }
}

class CanServeSiteDummy
{
    use CanServeSite;

    /**
     * Get Application's base path.
     *
     * @var string
     *
     * @return string
     */
    public static function applicationBasePath()
    {
        return default_skeleton_path();
    }

    /**
     * Get Application's base URL.
     *
     * @var string
     *
     * @return string
     */
    public static function applicationBaseUrl()
    {
        return \sprintf('http://%s:%d', self::getBaseServeHost(), self::getBaseServePort());
    }

    /**
     * The base server port.
     *
     * @return int
     */
    public static function getBaseServePort()
    {
        return 8001;
    }

    /**
     * The base server host.
     *
     * @return string
     */
    public static function getBaseServeHost()
    {
        return '127.0.0.1';
    }
}
