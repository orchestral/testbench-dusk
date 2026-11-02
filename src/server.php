<?php

use Orchestra\Testbench\Dusk\DuskServer;

use function Orchestra\Sidekick\join_paths;

// Simple server script, which pulls in large part from the framework.
// It has been adapted so we can reconstruct the application to the
// required state on each request (based on the calling Test Class)

// This file allows us to emulate Apache's "mod_rewrite" functionality from the
// built-in PHP web server. This provides a convenient way to test a Laravel
// application without having installed a "real" web server software here.

$uri = urldecode(
    (string) parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);

// =========================================================================================
// Laravel routes through public/index.php but we need to build the application differently.
// =========================================================================================

define('LARAVEL_START', microtime(true));

require is_file(__DIR__.'/../vendor/autoload.php')
    ? __DIR__.'/../vendor/autoload.php'
    : __DIR__.'/../../../autoload.php';

$app = DuskServer::laravel(host: $_SERVER['SERVER_NAME'], port: $_SERVER['SERVER_PORT']);

// Emulation of mod_rewrite, but we use the applications set base path
if ($uri !== '/' && file_exists(join_paths($app->basePath(), 'public', $uri))) {
    return false;
}

// Process the request as per a normal Laravel request
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$response->send();

$kernel->terminate($request, $response);
