<?php

namespace Orchestra\Testbench\Dusk\Tests\Unit;

use Exception;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;

class TestCase extends PHPUnitTestCase
{
    protected function waitForServerToStart()
    {
        $i = 0;

        while (! $this->isServerUp()) {
            sleep(1);
            $i++;

            if ($i >= 5) {
                throw new Exception('Waited too long for server to start.');
            }
        }
    }

    protected function waitForServerToStop()
    {
        $i = 0;

        while ($this->isServerUp()) {
            sleep(1);
            $i++;

            if ($i >= 5) {
                throw new Exception('Waited too long for server to stop.');
            }
        }
    }

    protected function isServerUp()
    {
        if ($socket = @fsockopen('127.0.0.1', 8001, $errorNumber, $errorString, $timeout = 1)) {
            fclose($socket);

            return true;
        }

        return false;
    }
}
