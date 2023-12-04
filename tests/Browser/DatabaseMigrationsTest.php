<?php

namespace Orchestra\Testbench\Dusk\Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Schema;
use Orchestra\Testbench\Attributes\WithMigration;
use Orchestra\Testbench\Concerns\WithWorkbench;
use Orchestra\Testbench\Dusk\TestCase;
use PHPUnit\Framework\Attributes\Test;

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

    #[Test]
    public function it_can_migrate_and_reset_the_database()
    {
        $this->assertTrue(Schema::hasTable('tests'));
    }

    #[Test]
    #[WithMigration]
    #[WithMigration('notifications')]
    public function it_can_migrate_laravel_migrations()
    {
        $this->assertTrue(Schema::hasTable('users'));
        $this->assertTrue(Schema::hasTable('notifications'));
        $this->assertFalse(Schema::hasTable('sessions'));
    }
}
