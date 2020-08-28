#!/bin/bash

cp -rf vendor/laravel/laravel/config/*.php laravel/config/
cp -rf vendor/laravel/laravel/database/migrations/*.php laravel/migrations/
cp -rf vendor/laravel/laravel/resources/lang/en/*.php laravel/resources/lang/en/

awk '{sub(/ Package Service Providers.../," Dusk Service Provider\n         \*\/\n        Laravel\\Dusk\\DuskServiceProvider::class,\n\n        \/\*\n         * Package Service Providers...")}1' laravel/config/app.php > laravel/config/temp.stub && mv laravel/config/temp.stub laravel/config/app.php
awk '{sub(/production/,"testing")}1' laravel/config/app.php > laravel/config/temp.stub && mv laravel/config/temp.stub laravel/config/app.php
awk '{sub(/App\\Providers/,"// App\\Providers")}1' laravel/config/app.php > laravel/config/temp.stub && mv laravel/config/temp.stub laravel/config/app.php
awk '{sub(/\x27Redis\x27/,"'\''RedisManager'\''")}1' laravel/config/app.php > laravel/config/temp.stub && mv laravel/config/temp.stub laravel/config/app.php
awk '{sub(/\x27model\x27 => App\\User/,"'\''model'\'' => Illuminate\\Foundation\\Auth\\User")}1' laravel/config/auth.php > laravel/config/temp.stub && mv laravel/config/temp.stub laravel/config/auth.php
