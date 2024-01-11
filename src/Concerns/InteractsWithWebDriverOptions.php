<?php

namespace Orchestra\Testbench\Dusk\Concerns;

use PHPUnit\Framework\Attributes\BeforeClass;

trait InteractsWithWebDriverOptions
{
    /**
     * Prepare the testing environment web driver options.
     *
     * @return void
     *
     * @codeCoverageIgnore
     */
    #[BeforeClass]
    public static function setUpBeforeClassForInteractsWithWebDriverOptions()
    {
        static::defineWebDriverOptions();
    }

    /**
     * Prepare the testing environment web driver options.
     *
     * @return void
     */
    public static function defineWebDriverOptions()
    {
        //
    }
}
