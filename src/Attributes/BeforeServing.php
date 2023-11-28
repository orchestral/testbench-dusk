<?php

namespace Orchestra\Testbench\Dusk\Attributes;

use Attribute;
use Closure;
use Orchestra\Testbench\Contracts\Attributes\Actionable as ActionableContract;

#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_METHOD)]
final class BeforeServing implements ActionableContract
{
    /**
     * The target method.
     *
     * @var string
     */
    public $method;

    /**
     * Construct a new attribute.
     *
     * @param  string  $method
     */
    public function __construct(string $method)
    {
        $this->method = $method;
    }

    /**
     * Handle the attribute.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @param  \Closure(string, array<int, mixed>):void  $action
     */
    public function handle($app, Closure $action): void
    {
        return function ($app, $config) use ($action) {
            /**
             * @var \Illuminate\Foundation\Application $app
             * @var \Illuminate\Contracts\Config\Repository $config
             */
            \call_user_func($action, $this->method, [$app, $config]);
        };
    }
}
