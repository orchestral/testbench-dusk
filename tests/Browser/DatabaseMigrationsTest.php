<?php

namespace Orchestra\Testbench\Dusk\Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Schema;
use Orchestra\Testbench\Concerns\WithWorkbench;
use Orchestra\Testbench\Dusk\TestCase;

class DatabaseMigrationsTest extends TestCase
{
    use DatabaseMigrations, WithWorkbench;

    protected function setUp(): void
    {
        $this->beforeApplicationDestroyed(function () {
            $this->assertFalse(Schema::hasTable('tests'));
        });

        parent::setUp();
    }

    /** @test */
    public function it_can_migrate_and_reset_the_database()
    {
        $this->assertTrue(Schema::hasTable('tests'));
    }
}
