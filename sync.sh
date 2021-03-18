#!/bin/bash

cp -rf vendor/laravel/laravel/config/*.php laravel/config/
cp -rf vendor/laravel/laravel/database/migrations/2014_10_12_000000_create_users_table.php laravel/migrations/2014_10_12_000000_testbench_create_users_table.php
cp -rf vendor/laravel/laravel/database/migrations/2014_10_12_100000_create_password_resets_table.php laravel/migrations/2014_10_12_100000_testbench_create_password_resets_table.php
cp -rf vendor/laravel/laravel/database/migrations/2019_08_19_000000_create_failed_jobs_table.php laravel/migrations/2019_08_19_000000_testbench_create_failed_jobs_table.php
cp -rf vendor/laravel/laravel/resources/lang/en/*.php laravel/resources/lang/en/
cp -rf vendor/laravel/laravel/server.php laravel/server.php
cp -rf vendor/laravel/laravel/public/index.php laravel/public/index.php
cp -rf vendor/laravel/dusk/stubs/phpunit.xml stubs/phpunit.xml

awk '{sub(/ Package Service Providers.../," Dusk Service Provider\n         \*\/\n        Laravel\\Dusk\\DuskServiceProvider::class,\n\n        \/\*\n         * Package Service Providers...")}1' laravel/config/app.php > laravel/config/temp.stub && mv laravel/config/temp.stub laravel/config/app.php
awk '{sub(/production/,"testing")}1' laravel/config/app.php > laravel/config/temp.stub && mv laravel/config/temp.stub laravel/config/app.php
awk '{sub(/App\\Providers/,"// App\\Providers")}1' laravel/config/app.php > laravel/config/temp.stub && mv laravel/config/temp.stub laravel/config/app.php
# awk '{sub(/\x27Redis\x27/,"'\''RedisManager'\''")}1' laravel/config/app.php > laravel/config/temp.stub && mv laravel/config/temp.stub laravel/config/app.php
awk '{sub(/\x27model\x27 => App\\Models\\User/,"'\''model'\'' => Illuminate\\Foundation\\Auth\\User")}1' laravel/config/auth.php > laravel/config/temp.stub && mv laravel/config/temp.stub laravel/config/auth.php
awk '{sub(/class Create/,"class TestbenchCreate")}1' laravel/migrations/2014_10_12_000000_testbench_create_users_table.php > laravel/migrations/temp.stub && mv laravel/migrations/temp.stub laravel/migrations/2014_10_12_000000_testbench_create_users_table.php
awk '{sub(/class Create/,"class TestbenchCreate")}1' laravel/migrations/2014_10_12_100000_testbench_create_password_resets_table.php > laravel/migrations/temp.stub && mv laravel/migrations/temp.stub laravel/migrations/2014_10_12_100000_testbench_create_password_resets_table.php
awk '{sub(/class Create/,"class TestbenchCreate")}1' laravel/migrations/2019_08_19_000000_testbench_create_failed_jobs_table.php > laravel/migrations/temp.stub && mv laravel/migrations/temp.stub laravel/migrations/2019_08_19_000000_testbench_create_failed_jobs_table.php
