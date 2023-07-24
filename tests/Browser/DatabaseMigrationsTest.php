<?php

namespace Orchestra\Testbench\Dusk\Tests\Browser;

use Illuminate\Support\Facades\Schema;
use Orchestra\Testbench\Dusk\TestCase;

class DatabaseMigrationsTest extends TestCase
{
    protected function setUp(): void
    {
        $this->beforeApplicationDestroyed(function () {
            $this->assertFalse(Schema::hasTable('tests'));
        });

        parent::setUp();
    }

    /**
     * Define database migrations.
     *
     * @return void
     */
    protected function defineDatabaseMigrations()
    {
        $this->loadMigrationsFrom(__DIR__.'/../migrations');
    }

    /** @test */
    public function it_can_migrate_and_reset_the_database()
    {
        $this->assertTrue(Schema::hasTable('tests'));
    }
}
