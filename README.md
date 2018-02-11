Laravel Dusk Testing Helper for Packages Development
==============

The Testbench Dusk Component is a simple package that is supposed to help you write tests for your Laravel package using Laravel Dusk.

The package was developed by [Konsulting Ltd](https://github.com/konsulting) and transferred to the Orchestra namespace where we will assist with supporting it in the future. It is in early development and feedback is appreciated.

[![Build Status](https://travis-ci.org/orchestral/testbench-dusk.svg?branch=3.6)](https://travis-ci.org/orchestral/testbench-dusk)
[![Latest Stable Version](https://poser.pugx.org/orchestra/testbench-dusk/v/stable)](https://packagist.org/packages/orchestra/testbench-dusk)
[![Total Downloads](https://poser.pugx.org/orchestra/testbench-dusk/downloads)](https://packagist.org/packages/orchestra/testbench-dusk)
[![Latest Unstable Version](https://poser.pugx.org/orchestra/testbench-dusk/v/unstable)](https://packagist.org/packages/orchestra/testbench-dusk)
[![License](https://poser.pugx.org/orchestra/testbench-dusk/license)](https://packagist.org/packages/orchestra/testbench-dusk)

* [Version Compatibility](#version-compatibility)
* [Getting Started](#getting-started)
* [Installation](#installation)
* [Usage](#usage)
* [Advanced Usage](#advanced-usage)
* [Changelog](https://github.com/orchestral/testbench-dusk/releases)

## Version Compatibility

 Laravel  | Testbench Dusk
:---------|:----------
 5.4.x    | 3.4.x
 5.5.x    | 3.5.x
 5.6.x.   | 3.6.x@dev

## Getting Started

Before going through the rest of this documentation, please take some time to read the following documentation:

* [Package Development for Laravel](https://laravel.com/docs/5.4/packages)
* [Orchestra Testbench Documentation](https://github.com/orchestral/testbench/blob/3.4/README.md)
* [Laravel Dusk Documentation](https://laravel.com/docs/5.4/dusk)

## Installation

To install through composer, simply put the following in your `composer.json` file:

```json
{
    "require-dev": {
        "orchestra/testbench-dusk": "~3.4"
    }
}
```

And then run `composer install` from the terminal.

### Quick Installation

Above installation can also be simplify by using the following command:

    composer require --dev "orchestra/testbench-dusk=~3.4"

## Usage

To use Testbench Dusk Component, all you need to do is extend `Orchestra\Testbench\Dusk\TestCase` instead of `Laravel\Dusk\TestCase`. The fixture app booted by `Orchestra\Testbench\Dusk\TestCase` is predefined to follow the base application skeleton of Laravel 5.

```php
<?php

class BrowserTestCase extends Orchestra\Testbench\Dusk\TestCase
{
    //
}
```

### Custom Host and Port

By default, Tesbench Dusk will start its own PHP server at `http://127.0.0.1:8000`.

You can customize this by replacing the `$baseServeHost` and `$baseServePort` such as below:

```php
<?php

class BrowserTestCase extends Orchestra\Testbench\Dusk\TestCase
{
    protected static $baseServeHost = '127.0.0.1';
    protected static $baseServePort = 9000;
}
```

## Advanced Usage

### Customising the Laravel App instance used during a test

We use the calling test class to build up the application to be used when serving the request.

Sometimes you will want to make a minor change to the application for a single test (e.g. changing a config item).

This is made possible by using the `tweakApplication` method on the test, and passing in a closure to apply. At the end of the test, you need to call the `removeApplicationTweaks` method to stop the changes being applied to the server.

An example test (`can_tweak_the_application_within_a_test`) is available in the `tests/Browser/RouteTest.php` test file.

### Selectively running Dusk tests

Browser tests can take a while to run, so you could also separate your tests in your `phpunit.xml` file by providing different testsuites, allowing you to run your Browser tests on demand.

For example:

```xml
<testsuites>
    <testsuite name="Browser">
        <directory suffix="Test.php">./tests/Browser</directory>
    </testsuite>
    <testsuite name="Feature">
        <directory suffix="Test.php">./tests/Feature</directory>
    </testsuite>
    <testsuite name="Unit">
        <directory suffix="Test.php">./tests/Unit</directory>
    </testsuite>
</testsuites>
```

Run only your browser tests by running phpunit with the `--testsuite=Browser` option.

You can optionally set the default testsuite with the option `defaultTestSuite="Unit"`.

