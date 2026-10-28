<?php

use Amp\Http\Server\DefaultErrorHandler;
use Amp\Http\Server\Request as AmpRequest;
use Amp\Http\Server\RequestHandler\ClosureRequestHandler;
use Amp\Http\Server\Response as AmpResponse;
use Amp\Http\Server\SocketHttpServer;
use Amp\Socket\InternetAddress;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;
use Orchestra\Testbench\Dusk\DuskServer;
use Orchestra\Testbench\Dusk\TestCase;
use Psr\Log\NullLogger;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\Mime\MimeTypes;

use function Amp\trapSignal;
use function Orchestra\Sidekick\Filesystem\join_paths;

// Long running server based on `amphp/http-server`. The application is
// reconstructed on every request based on the calling Test Class
// so the server always reflects the latest contents pushed by the test process.

require is_file(__DIR__.'/../vendor/autoload.php')
    ? __DIR__.'/../vendor/autoload.php'
    : __DIR__.'/../../../autoload.php';

define('LARAVEL_START', microtime(true));

$host = $argv[1] ?? '127.0.0.1';
$port = (int) ($argv[2] ?? 8001);

$orchestraServer = new DuskServer($host, $port);

$handler = new ClosureRequestHandler(function (AmpRequest $ampRequest) use ($orchestraServer, $host, $port): AmpResponse {
    $uri = $ampRequest->getUri();
    $path = urldecode($uri->getPath());

    // Contents pushed directly from the test process.
    if ($path === DuskServer::STASH_PATH) {
        $token = preg_replace('/^Bearer\s+/i', '', $ampRequest->getHeader('authorization') ?? '');

        if ($ampRequest->getMethod() !== 'POST' || ! $orchestraServer->isAuthorized($token)) {
            return new AmpResponse(status: 403);
        }

        $orchestraServer->receive(json_decode($ampRequest->getBody()->buffer(), true) ?? []);

        return new AmpResponse(status: 204);
    }

    /** @var class-string<TestCase> $originatingTestClass */
    $originatingTestClass = $orchestraServer->getStash('class');

    // Abstract base classes (e.g. when using Pest) need a concrete class to be instantiated.
    if ((new ReflectionClass($originatingTestClass))->isAbstract()) {
        /** @var class-string<TestCase> $concreteTestClass */
        $concreteTestClass = 'TestbenchDuskServing'.md5($originatingTestClass);

        if (! class_exists($concreteTestClass, false)) {
            eval(sprintf('final class %s extends \\%s {}', $concreteTestClass, ltrim($originatingTestClass, '\\')));
        }

        $originatingTestClass = $concreteTestClass;
    }

    $app = (new $originatingTestClass('laravel'))->createServingApplicationForDuskServer($orchestraServer);

    // Emulation of mod_rewrite, serve existing files from the public path.
    $publicPath = realpath(join_paths($app->basePath(), 'public'));
    $file = $publicPath !== false ? realpath(join_paths($publicPath, $path)) : false;

    if ($path !== '/' && $file !== false && is_file($file) && str_starts_with($file, $publicPath.DIRECTORY_SEPARATOR) && pathinfo($file, PATHINFO_EXTENSION) !== 'php') {
        return new AmpResponse(
            headers: ['content-type' => (new MimeTypes)->getMimeTypes(pathinfo($file, PATHINFO_EXTENSION))[0] ?? 'application/octet-stream'],
            body: (string) file_get_contents($file),
        );
    }

    $content = $ampRequest->getBody()->buffer();
    $method = strtoupper($ampRequest->getMethod());
    $contentType = strtolower($ampRequest->getHeader('content-type') ?? '');

    $server = [
        'SERVER_NAME' => $host,
        'SERVER_PORT' => $port,
        'HTTP_HOST' => $ampRequest->getHeader('host') ?? sprintf('%s:%d', $host, $port),
        'REMOTE_ADDR' => $ampRequest->getClient()->getRemoteAddress()->toString(),
        'REQUEST_URI' => $uri->getPath().($uri->getQuery() !== '' ? '?'.$uri->getQuery() : ''),
        'QUERY_STRING' => $uri->getQuery(),
        'CONTENT_TYPE' => $ampRequest->getHeader('content-type') ?? '',
        'CONTENT_LENGTH' => (string) strlen($content),
    ];

    foreach ($ampRequest->getHeaders() as $name => $values) {
        $server['HTTP_'.strtoupper(str_replace('-', '_', $name))] = implode(', ', $values);
    }

    $cookies = [];

    foreach (explode(';', $ampRequest->getHeader('cookie') ?? '') as $pair) {
        [$name, $value] = array_pad(explode('=', trim($pair), 2), 2, '');

        if ($name !== '') {
            $cookies[urldecode($name)] = urldecode($value);
        }
    }

    $parameters = [];

    if (str_starts_with($contentType, 'application/x-www-form-urlencoded') && ! in_array($method, ['GET', 'HEAD'])) {
        parse_str($content, $parameters);
    }

    $request = Request::create(
        (string) $uri->withScheme('http')->withHost($host)->withPort($port),
        $method,
        $parameters,
        $cookies,
        [],
        $server,
        $content,
    );

    $kernel = $app->make(Kernel::class);
    $response = $kernel->handle($request);

    if ($response instanceof BinaryFileResponse || $response instanceof StreamedResponse) {
        ob_start();
        $response->sendContent();
        $body = (string) ob_get_clean();
    } else {
        $body = (string) $response->getContent();
    }

    $headers = [];

    foreach ($response->headers->allPreserveCaseWithoutCookies() as $name => $values) {
        $headers[$name] = $values;
    }

    $headers['set-cookie'] = array_map(static fn ($cookie) => (string) $cookie, $response->headers->getCookies());

    if ($headers['set-cookie'] === []) {
        unset($headers['set-cookie']);
    }

    unset($headers['Content-Length'], $headers['Transfer-Encoding']);

    $kernel->terminate($request, $response);

    return new AmpResponse(status: $response->getStatusCode(), headers: $headers, body: $body);
});

$logger = new NullLogger;
$httpServer = SocketHttpServer::createForDirectAccess($logger);
$httpServer->expose(new InternetAddress($host, max(0, min(65535, $port))));
$httpServer->start($handler, new DefaultErrorHandler);

trapSignal([SIGINT, SIGTERM]);

$httpServer->stop();
