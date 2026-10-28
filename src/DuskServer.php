<?php

namespace Orchestra\Testbench\Dusk;

use Orchestra\Testbench\Foundation\Process\RemoteWebServer;
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
     * Store some temp contents in a file for later use.
     *
     * @param  mixed  $content
     * @return void
     */
    public function stash($content): void
    {
        file_put_contents($this->temp(), json_encode($content));
    }

    /**
     * Prepare the path of the temp file for a particular server.
     *
     * @return string
     */
    protected function temp(): string
    {
        return join_paths(
            \dirname(__DIR__),
            'tmp',
            \sprintf('%s__%d', ! \in_array($this->host, $this->localIpv6Hosts) ? $this->host : 'localhost', $this->port),
        );
    }

    /**
     * Retrieve the contents of the relevant file.
     *
     * @param  string|null  $key
     * @return mixed
     */
    public function getStash(?string $key = null)
    {
        $content = json_decode((string) file_get_contents($this->temp()), true);

        return $key ? ($content[$key] ?? null) : $content;
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
     * pointer to it. Output is discarded: the built-in PHP
     * server logs every request to stderr, and if that pipe
     * is never drained it fills and blocks the server.
     *
     * @see https://github.com/orchestral/testbench-dusk/issues/123
     */
    protected function createWebServerProcess(): Process
    {
        $process = new Process(
            command: $this->prepareCommand(),
            cwd: join_paths($this->basePath(), 'public'),
            env: array_merge(defined_environment_variables(), [
                'APP_BASE_PATH' => $this->basePath(),
                'APP_URL' => $this->baseUrl(),
                'APP_ENV' => 'testing',
                'TESTBENCH_WORKING_PATH' => package_path(),
            ]),
            timeout: $this->timeout
        );

        // Discard stdout/stderr so the OS pipe cannot fill and hang php -S
        // mid-suite when request log volume exceeds the pipe buffer.
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
        if (Options::$usesAmphpServer) {
            return [
                php_binary(),
                join_paths(__DIR__, 'amphp-server.php'),
                $this->host,
                (string) $this->port,
            ];
        }

        return [
            php_binary(),
            '-S',
            \sprintf('%s:%s', $this->host, $this->port),
            join_paths(__DIR__, 'server.php'),
            '-t',
            join_paths($this->basePath(), 'public'),
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
