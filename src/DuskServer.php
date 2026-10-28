<?php

namespace Orchestra\Testbench\Dusk;

use Orchestra\Testbench\Foundation\Process\RemoteWebServer;
use RuntimeException;
use Symfony\Component\Process\Process;

use function Orchestra\Sidekick\Filesystem\join_paths;
use function Orchestra\Sidekick\php_binary;
use function Orchestra\Testbench\defined_environment_variables;
use function Orchestra\Testbench\package_path;

/**
 * @internal
 */
class DuskServer extends RemoteWebServer
{
    /**
     * Laravel working path.
     *
     * @var string|null
     */
    protected ?string $basePath = null;

    /**
     * Laravel working URL.
     *
     * @var string|null
     */
    protected ?string $baseUrl = null;

    /**
     * List of local IPv6 hosts.
     *
     * @var array<int, string>
     */
    protected array $localIpv6Hosts = ['::0', '[::0]'];

    /**
     * Path used to push stashed contents to the server.
     */
    public const STASH_PATH = '/__testbench_dusk/stash';

    /**
     * Environment variable used to share the push token with the server process.
     */
    public const TOKEN_ENVIRONMENT_NAME = 'TESTBENCH_DUSK_SERVER_TOKEN';

    /**
     * Stashed contents shared between the test and server process.
     *
     * @var mixed
     */
    protected $stashed = [];

    /**
     * Token used to authorize pushing contents to the server.
     */
    protected string $token = '';

    /**
     * Construct a new web server.
     *
     * @param  string  $host
     * @param  int  $port
     * @param  int  $timeout
     */
    public function __construct(
        public readonly string $host = '127.0.0.1',
        public readonly int $port = 8001,
        public readonly int $timeout = 6000,
    ) {}

    /**
     * Set Laravel working path.
     *
     * @param  string|null  $basePath
     * @param  string|null  $baseUrl
     * @return void
     */
    public function setLaravel(?string $basePath = null, ?string $baseUrl = null): void
    {
        $this->basePath = $basePath;
        $this->baseUrl = $baseUrl;
    }

    /**
     * Store contents to be shared with the running server.
     *
     * The contents are kept in memory and pushed directly to the server
     * process (when it is running), otherwise it will be pushed on start.
     *
     * @param  mixed  $content
     * @return void
     */
    public function stash($content): void
    {
        $this->stashed = $content;

        if ($this->process?->isRunning()) {
            $this->pushStash();
        }
    }

    /**
     * Receive the stashed contents sent from the test process.
     *
     * @internal
     *
     * @param  mixed  $content
     * @return void
     */
    public function receive($content): void
    {
        $this->stashed = $content;
    }

    /**
     * Determine whether the given token is allowed to push contents to the server.
     *
     * @internal
     */
    public function isAuthorized(?string $token): bool
    {
        $expected = getenv(static::TOKEN_ENVIRONMENT_NAME);

        return \is_string($expected) && $expected !== '' && \is_string($token) && hash_equals($expected, $token);
    }

    /**
     * Retrieve the stashed contents.
     *
     * @param  string|null  $key
     * @return mixed
     */
    public function getStash(?string $key = null)
    {
        return $key ? ($this->stashed[$key] ?? null) : $this->stashed;
    }

    /**
     * Push the stashed contents to the server process.
     *
     * @return void
     *
     * @throws \RuntimeException
     */
    protected function pushStash(): void
    {
        $host = \in_array($this->host, $this->localIpv6Hosts) ? '[::1]' : $this->host;

        $response = @file_get_contents(\sprintf('http://%s:%d%s', $host, $this->port, static::STASH_PATH), false, stream_context_create([
            'http' => [
                'method' => 'POST',
                'header' => \sprintf("Content-Type: application/json\r\nAuthorization: Bearer %s\r\n", $this->token),
                'content' => json_encode($this->stashed),
                'ignore_errors' => true,
                'timeout' => 10,
            ],
        ]));

        if ($response === false || ! str_contains($http_response_header[0] ?? '', ' 204')) {
            throw new RuntimeException(\sprintf('Unable to push contents to server on %s:%d.', $this->host, $this->port));
        }
    }

    /**
     * {@inheritDoc}
     */
    #[\Override]
    protected function startServer(): void
    {
        parent::startServer();

        if ($this->stashed !== []) {
            $this->pushStash();
        }
    }

    /**
     * Stop the php server.
     *
     * @return void
     */
    public function restart(): void
    {
        $this->stop();
        $this->clearOutput();
        $this->startServer();
    }

    /**
     * {@inheritDoc}
     *
     * Start the server. Execute the command and open a
     * pointer to it. Output is discarded so an
     * undrained pipe can never fill and block the server.
     *
     * @see https://github.com/orchestral/testbench-dusk/issues/123
     */
    protected function createWebServerProcess(): Process
    {
        $this->token = bin2hex(random_bytes(16));

        $process = new Process(
            command: $this->prepareCommand(),
            cwd: join_paths($this->basePath(), 'public'),
            env: array_merge(defined_environment_variables(), [
                'APP_BASE_PATH' => $this->basePath(),
                'APP_URL' => $this->baseUrl(),
                'APP_ENV' => 'testing',
                'TESTBENCH_WORKING_PATH' => package_path(),
                static::TOKEN_ENVIRONMENT_NAME => $this->token,
            ]),
            timeout: $this->timeout
        );

        // Discard stdout/stderr so the OS pipe cannot fill and hang the
        // server mid-suite when output volume exceeds the pipe buffer.
        $process->disableOutput();

        return $process;
    }

    /**
     * Prepare the command for starting the PHP server.
     *
     * @return array
     */
    protected function prepareCommand(): array
    {
        return [
            php_binary(),
            join_paths(__DIR__, 'server.php'),
            $this->host,
            (string) $this->port,
        ];
    }

    /**
     * Figure out the path to the laravel application path for Testbench purposes.
     *
     * @return string
     */
    public function basePath(): string
    {
        return $this->basePath ?? default_skeleton_path();
    }

    /**
     * Figure out the path to the laravel application URL for testbench purposes.
     *
     * @return string
     */
    public function baseUrl(): string
    {
        return $this->baseUrl ?? \sprintf('http://%s:%d', $this->host, $this->port);
    }

    /**
     * {@inheritDoc}
     *
     * @throws \Orchestra\Testbench\Dusk\Exceptions\UnableToStartServer
     */
    #[\Override]
    protected function throwUnableToStartWebServer(): never
    {
        throw new Exceptions\UnableToStartServer(\sprintf('%s:%d', $this->host, $this->port));
    }
}
