<?php

namespace Orchestra\Testbench\Dusk\Attributes;

use Attribute;
use Closure;
use Orchestra\Testbench\Contracts\Attributes\Actionable as ActionableContract;

#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_METHOD)]
final class BeforeServing implements ActionableContract
{
    /**
     * Construct a new attribute.
     *
     * @param  string  $method
     */
    public function __construct(public string $method)
    {
        //
    }

    /**
     * Handle the attribute.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @param  \Closure(string, array<int, mixed>):void  $action
     * @return string
     */
    public function handle($app, Closure $action): string
    {
        return $this->method;
    }
}
