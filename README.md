Laravel Dusk Kit Testing Helper for Packages Development
==============

Testbench Component is a simple package that is supposed to help you write tests for your Laravel package, especially when there is routing involved.

This is a package developed by Konsulting Ltd to (we hope) be transferred to the original Orchestra namespace.

* [Version Compatibility](#version-compatibility)
* [Installation](#installation)
* [Usage](#usage)
* [Changelog](https://github.com/orchestral/testbench-browser-kit/releases)

## Version Compatibility

 Laravel  | Testbench Browser Kit
:---------|:----------
 5.5.x    | 3.5

## Installation

To install through composer, simply put the following in your `composer.json` file:

```json
{
    "require-dev": {
        "konsnulting/testbench-dusk": "~3.5"
    }
}
```

And then run `composer install` from the terminal.

### Quick Installation

Above installation can also be simplify by using the following command:

    composer require --dev "orchestra/testbench-dusk=~3.5"

## Usage

Use the `Orchestra\Testbench\Dusk\TestCase` as the parent class for your test. Optionally, extend that class to provide a custom base class for your project.

You can also separate your tests in your `phpunit.xml` file by providing different testsuites. For example:
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

You can optionally set the default testsuite with the option `defaultTestSuite="Unit"`

## Advanced usage

This package sets up a separate process running the required web-server using PHP's built in web server, by default at 127.0.0.1:8000. We use the calling test class' to build up the application to be used when serving.

Sometimes you will want to make a minor change to the application for a single test (e.g. changing a config item).

This is made possible by using the `tweakApplication` method on the test, and passing in a closure to apply. At the end of the test, you need to call the `removeApplicationTweaks` method to stop the changes being applied to the server.

An example test (`can_tweak_the_application_within_a_test`) is available in the `tests/Browser/RouteTest.php` test file.
