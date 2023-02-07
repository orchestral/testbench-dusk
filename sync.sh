#!/bin/bash

composer create-project "laravel/laravel:dev-bootstrap" skeleton --no-scripts --no-plugins --quiet

cp -f skeleton/.env.example laravel/
cp -rf skeleton/config/*.php laravel/config/
cp -rf skeleton/database/migrations/2014_10_12_000000_create_users_table.php laravel/migrations/2014_10_12_000000_testbench_create_users_table.php
cp -rf skeleton/database/migrations/2014_10_12_100000_create_password_reset_tokens_table.php laravel/migrations/2014_10_12_100000_testbench_create_password_reset_tokens_table.php
cp -rf skeleton/database/migrations/2019_08_19_000000_create_failed_jobs_table.php laravel/migrations/2019_08_19_000000_testbench_create_failed_jobs_table.php
cp -rf skeleton/resources/views/* laravel/resources/views/
cp -rf vendor/orchestra/testbench-core/laravel/server.php laravel/server.php
cp -rf vendor/orchestra/testbench-core/laravel/.gitignore laravel/.gitignore
cp -rf skeleton/public/index.php laravel/public/index.php
cp -rf vendor/laravel/dusk/stubs/phpunit.xml stubs/phpunit.xml
cp -rf skeleton/tests/CreatesApplication.php laravel/tests/CreatesApplication.php
rm laravel/config/sanctum.php

rm -Rf skeleton

awk '{sub(/DB_CONNECTION=mysql/,"DB_CONNECTION=sqlite")}1' laravel/.env.example > laravel/.env.example.stub && mv laravel/.env.example.stub laravel/.env.example
awk '{sub(/DB_HOST=/,"\# DB_HOST=")}1' laravel/.env.example > laravel/.env.example.stub && mv laravel/.env.example.stub laravel/.env.example
awk '{sub(/DB_PORT=/,"\# DB_PORT=")}1' laravel/.env.example > laravel/.env.example.stub && mv laravel/.env.example.stub laravel/.env.example
awk '{sub(/DB_DATABASE=/,"\# DB_DATABASE=")}1' laravel/.env.example > laravel/.env.example.stub && mv laravel/.env.example.stub laravel/.env.example
awk '{sub(/DB_USERNAME=/,"\# DB_USERNAME=")}1' laravel/.env.example > laravel/.env.example.stub && mv laravel/.env.example.stub laravel/.env.example
awk '{sub(/DB_PASSWORD=/,"\# DB_PASSWORD=")}1' laravel/.env.example > laravel/.env.example.stub && mv laravel/.env.example.stub laravel/.env.example
awk '{sub(/ Package Service Providers.../," Dusk Service Provider\n         \*\/\n        Laravel\\Dusk\\DuskServiceProvider::class,\n\n        \/\*\n         * Package Service Providers...")}1' laravel/config/app.php > laravel/config/app.stub && mv laravel/config/app.stub laravel/config/app.php
awk '{sub(/production/,"testing")}1' laravel/config/app.php > laravel/config/app.stub && mv laravel/config/app.stub laravel/config/app.php
awk '{sub(/App\\Providers/,"// App\\Providers")}1' laravel/config/app.php > laravel/config/app.stub && mv laravel/config/app.stub laravel/config/app.php
# awk '{sub(/\x27Redis\x27/,"'\''RedisManager'\''")}1' laravel/config/app.php > laravel/config/app.stub && mv laravel/config/app.stub laravel/config/app.php
awk '{sub(/\x27model\x27 => App\\Models\\User/,"'\''model'\'' => Illuminate\\Foundation\\Auth\\User")}1' laravel/config/auth.php > laravel/config/auth.stub && mv laravel/config/auth.stub laravel/config/auth.php
