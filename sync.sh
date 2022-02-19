#!/bin/bash

cp -rf vendor/laravel/laravel/config/*.php laravel/config/
cp -rf vendor/laravel/laravel/database/migrations/2014_10_12_000000_create_users_table.php laravel/migrations/2014_10_12_000000_testbench_create_users_table.php
cp -rf vendor/laravel/laravel/database/migrations/2014_10_12_100000_create_password_resets_table.php laravel/migrations/2014_10_12_100000_testbench_create_password_resets_table.php
cp -rf vendor/laravel/laravel/database/migrations/2019_08_19_000000_create_failed_jobs_table.php laravel/migrations/2019_08_19_000000_testbench_create_failed_jobs_table.php
cp -rf vendor/orchestra/testbench-core/laravel/lang/en/*.php laravel/lang/en/
cp -f vendor/orchestra/testbench-core/laravel/lang/*.json laravel/lang/
cp -rf vendor/orchestra/testbench-core/laravel/server.php laravel/server.php
cp -rf vendor/laravel/laravel/public/index.php laravel/public/index.php
cp -rf vendor/laravel/dusk/stubs/phpunit.xml stubs/phpunit.xml
rm laravel/config/sanctum.php

awk '{sub(/ Package Service Providers.../," Dusk Service Provider\n         \*\/\n        Laravel\\Dusk\\DuskServiceProvider::class,\n\n        \/\*\n         * Package Service Providers...")}1' laravel/config/app.php > laravel/config/app.stub && mv laravel/config/app.stub laravel/config/app.php
awk '{sub(/production/,"testing")}1' laravel/config/app.php > laravel/config/app.stub && mv laravel/config/app.stub laravel/config/app.php
awk '{sub(/App\\Providers/,"// App\\Providers")}1' laravel/config/app.php > laravel/config/app.stub && mv laravel/config/app.stub laravel/config/app.php
# awk '{sub(/\x27Redis\x27/,"'\''RedisManager'\''")}1' laravel/config/app.php > laravel/config/app.stub && mv laravel/config/app.stub laravel/config/app.php
awk '{sub(/\x27model\x27 => App\\Models\\User/,"'\''model'\'' => Illuminate\\Foundation\\Auth\\User")}1' laravel/config/auth.php > laravel/config/auth.stub && mv laravel/config/auth.stub laravel/config/auth.php
