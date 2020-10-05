<?php

namespace Orchestra\Testbench\Dusk\Tests\Unit\Concerns;

use Orchestra\Testbench\Dusk\Concerns\CanServeSite;
use Orchestra\Testbench\Dusk\Tests\Unit\TestCase;

class CanServeSiteTest extends TestCase
{
    /** @test * */
    public function it_starts_and_stops_a_server()
    {
        $dummy = new CanServeSiteDummy();

        $dummy::serve('127.0.0.1', 8001);

        $this->assertFalse($dummy->getServer()->getProcess()->isTerminated());

        // It can take a little time to get up and running.
        $this->waitForServerToStart();
        $this->assertTrue($this->isServerUp());

        $dummy::stopServing();
        $this->waitForServerToStop();

        $this->assertTrue($dummy->getServer()->getProcess()->isTerminated());
        $this->assertFalse($this->isServerUp());
    }

    /** @test * */
    public function it_stops_an_existing_server_and_starts_a_new_one_with_consecutive_serve_requests()
    {
        $dummy = new CanServeSiteDummy();

        $dummy::serve('127.0.0.1', 8001);

        $duskServerOne = $dummy->getServer();
        // we don't bother waiting since that is tested in 'it_starts_and_stops_a_server'

        $dummy::serve('127.0.0.1', 8001);

        $duskServerTwo = $dummy->getServer();

        $this->assertNotSame($duskServerOne, $duskServerTwo);
        $this->assertTrue($duskServerOne->getProcess()->isTerminated());
        $this->assertFalse($duskServerTwo->getProcess()->isTerminated());

        $dummy::stopServing();
    }
}

class CanServeSiteDummy
{
    use CanServeSite;

    /**
     * Get base path.
     *
     * @return string
     */
    protected function getBasePath()
    {
        return __DIR__.'/../../../laravel';
    }
}
