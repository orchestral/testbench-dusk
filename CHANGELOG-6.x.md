# Change for 6.x

This changelog references the relevant changes (bug and security fixes) done to `orchestra/testbench-dusk`.

## 6.23.3

Released: 2021-12-28

### Changes

* Update minimum support for Testbench v6.23.2+. ([v6.23.1...v6.23.2](https://github.com/orchestral/testbench/compare/v6.23.1...v6.23.2))
* Update skeleton to match v8.6.10.

## 6.23.2

Released: 2021-12-04

### Changes

* Update minimum support for Testbench v6.23.1+. ([v6.23.0...v6.23.1](https://github.com/orchestral/testbench/compare/v6.23.0...v6.23.1))
* Support path containing spaces on Windows environment.

## 6.23.1

Released: 2021-11-10

### Changes

* Update minimum support for Testbench v6.23.0+. ([v6.20.0...v6.23.0](https://github.com/orchestral/testbench/compare/v6.20.0...v6.23.0))

## 6.23.0

Released: 2021-10-21

### Changes

* Update minimum support for Testbench v6.22.0+. ([v6.21.1...v6.22.0](https://github.com/orchestral/testbench/compare/v6.21.1...v6.22.0))
* Update minimum support for Laravel Dusk v6.19.2+. ([v6.18.1...v6.19.2](https://github.com/laravel/dusk/compare/v6.18.1...v6.19.2))
* Update skeleton to match v8.6.4.

## 6.22.2

Released: 2021-10-08

### Added

* Added support for `laravel/serializable-closure`.

## 6.22.1

Released: 2021-10-02

### Fixes

* Fixes missing `--pest` options on `package:dusk` command.

## 6.22.0

Released: 2021-09-18

### Changes

* Update minimum support for Testbench v6.21.1+. ([v6.20.1...v6.21.1](https://github.com/orchestral/testbench/compare/v6.20.1...v6.21.1))
* Update minimum support for Laravel Dusk v6.18.1+. ([v6.17.1...v6.18.1](https://github.com/laravel/dusk/compare/v6.17.1...v6.18.1))
* Update skeleton to match v8.6.2.

## 6.21.1

Released: 2021-08-25

### Changes

* Update minimum support for Testbench v6.20.1+. ([v6.20.0...v6.20.1](https://github.com/orchestral/testbench/compare/v6.20.0...v6.20.1))
* Update minimum support for Laravel Dusk v6.17.1+. ([v6.17.0...v6.17.1](https://github.com/laravel/dusk/compare/v6.17.0...v6.17.1))
* Update skeleton to match v8.6.1.

## 6.21.0

Released: 2021-08-12

### Changes

* Update minimum support for Testbench v6.20.0+. ([v6.19.0...v6.20.0](https://github.com/orchestral/testbench/compare/v6.19.0...v6.20.0))
* Update minimum support for Laravel Dusk v6.17.0+. ([v6.15.1...v6.17.0](https://github.com/laravel/dusk/compare/v6.15.1...v6.17.0))
* Update skeleton to match v8.5.24.

## 6.20.1

Released: 2021-07-14

### Changes

* Update skeleton to match v8.5.22.

## 6.20.0

Released: 2021-07-09

### Changes

* Update minimum support for Laravel Dusk v6.15.1+. ([v6.14.0...v6.15.1](https://github.com/laravel/dusk/compare/v6.14.0...v6.15.1))
* Update skeleton to match v8.5.21.
* Support Dusk Updater v2.

## 6.19.0

Released: 2021-07-01

### Added

* Added ability to configure w3c compliant using `Orchestra\Testbench\Dusk\Options::$w3cCompliant = true;`

### Changes

* Update minimum support for Testbench v6.19.0+. ([v6.18.0...v6.19.0](https://github.com/orchestral/testbench/compare/v6.18.0...v6.19.0))

## 6.18.0

Released: 2021-05-25

### Added

* Added static methods `applicationBasePath()` and `applicationBaseUrl()` to `Orchestra\Testbench\Dusk\TestCase`.

### Changes

* Update minimum support for Testbench v6.18.0+. ([v6.17.1...v6.18.0](https://github.com/orchestral/testbench/compare/v6.17.1...v6.18.0))

### Deprecated

* Deprecate `baseServeUrl()` method from `Orchestra\Testbench\Dusk\TestCase`.

## 6.17.2

Released: 2021-05-19

### Changes

* Update skeleton to match v8.5.18.

## 6.17.1

Released: 2021-05-19

### Changes

* Update minimum support for Testbench v6.17.1+. ([v6.17.0...v6.17.1](https://github.com/orchestral/testbench/compare/v6.17.0...v6.17.1))

## 6.17.0

Released: 2021-04-06

### Added

* Added `Orchestra\Testbench\Dusk\Options::$providesApplicationServer` property to allow disabling default serve web-server.

### Changes

* Update minimum support for Testbench v6.17.0+. ([v6.16.0...v6.17.0](https://github.com/orchestral/testbench/compare/v6.16.0...v6.17.0))
* Allow configuration to be loaded from `Application::basePath()` instead of hardcoded value.

## 6.16.0

Released: 2021-03-31

### Changes

* Update minimum support for Testbench v6.16.0+. ([v6.14.0...v6.16.0](https://github.com/orchestral/testbench/compare/v6.14.0...v6.16.0))
* Update minimum support for Laravel Dusk v6.14.0+. ([v6.12.0...v6.14.0](https://github.com/laravel/dusk/compare/v6.12.0...v6.14.0))
* Accept `APP_BASE_PATH` environment variable to configure `getBasePath()`.

## 6.15.1

Released: 2021-03-24

### Changes

* Rename `Orchestra\Testbench\Dusk\Foundation\Console\DuskPurgeCommand` to `Orchestra\Testbench\Dusk\Foundation\Console\PurgeCommand`.
* Update Laravel skeleton.
  - Update `validation` language file.
   
## 6.15.0

Released: 2021-03-21

### Added

* Added `TESTBENCH_WORKING_PATH` constant.
* Added `package:dusk` command using CLI Commander.
* Added `package:dusk-purge` command using CLI Commander.

### Changes

* Update minimum support for Testbench v6.15.0+. ([v6.14.0...v6.15.0](https://github.com/orchestral/testbench/compare/v6.14.0...v6.15.0))
* Improves preparing debugging tools for Dusk tests.

## 6.14.0

Released: 2021-03-16

### Changes

* Update minimum support for Testbench v6.14.0+. ([v6.13.0...v6.14.0](https://github.com/orchestral/testbench/compare/v6.13.0...v6.14.0))
* Update Laravel skeleton.
  - Add `Date` aliases.
  - Update `logging` configuration.
  - Update `validation` language file.

## 6.13.1

Released: 2021-03-10

### Changes

* Update Laravel skeleton.
  - Update `queue` configuration.
  - Update `validation` language file.

## 6.13.0

Released: 2021-02-21

### Changes

* Update minimum support for Testbench v6.13.0+. ([v6.12.1...v6.13.0](https://github.com/orchestral/testbench/compare/v6.12.1...v6.13.0))

## 6.12.1

Released: 2021-02-09

### Added

* Added `Orchestra\Testbench\Dusk\TestCase::hasHeadlessDisabled()` method.

### Changes

* Update minimum support for Testbench v6.12.1+. ([v6.11.0...v6.12.1](https://github.com/orchestral/testbench/compare/v6.11.0...v6.12.1))

## 6.12.0

Released: 2021-02-09

### Changes

* Update list of available methods on `Orchestra\Testbench\Dusk\Options`.
* Automatically set `--headless` when environment variable contains `CI=true`.

## 6.11.0

Released: 2021-01-31

### Changes

* Update minimum support for Testbench v6.11.0+. ([v6.10.0...v6.11.0](https://github.com/orchestral/testbench/compare/v6.10.0...v6.11.0))

## 6.10.0

Released: 2021-01-29

### Changes

* Update minimum support for Testbench v6.10.0+. ([v6.9.0...v6.10.0](https://github.com/orchestral/testbench/compare/v6.9.0...v6.10.0))

## 6.9.0

Released: 2021-01-18

### Changes

* Update minimum support for Testbench v6.9.0+. ([v6.8.0...v6.9.0](https://github.com/orchestral/testbench/compare/v6.8.0...v6.9.0))

## 6.8.0

Released: 2021-01-17

### Changes

* Update minimum support for Testbench v6.8.0+. ([v6.7.2...v6.8.0](https://github.com/orchestral/testbench/compare/v6.7.2...v6.8.0))

## 6.7.1

Released: 2020-12-31

### Changes

* Update minimum support for Laravel Dusk v6.11.0+. ([v6.5.0...v6.11.0](https://github.com/laravel/dusk/compare/v6.5.0...v6.11.0))
* Update minimum support for Testbench v6.7.2+. ([v6.7.0...v6.7.2](https://github.com/orchestral/testbench/compare/v6.7.0...v6.7.2))

## 6.7.0

Released: 2020-12-15

### Changes

* Update minimum support for Testbench v6.7.0+. ([v6.6.0...v6.7.0](https://github.com/orchestral/testbench/compare/v6.6.0...v6.7.0))

## 6.6.0

Released: 2020-12-10

### Changes

* Update minimum support for Testbench v6.6.0+. ([v6.5.0...v6.6.0](https://github.com/orchestral/testbench/compare/v6.5.0...v6.6.0))

## 6.5.0

Released: 2020-12-02

### Changes

* Update minimum support for Testbench v6.5.0+. ([v6.4.0...v6.5.0](https://github.com/orchestral/testbench/compare/v6.4.0...v6.5.0))

## 6.4.0

Released: 2020-11-20

### Changes

* Official support for PHP 8.
* Update app skeleton.

### Fixes

* Fixes `fsockopen` imcompatible usage on PHP 8.

## 6.3.0

Released: 2020-11-07

### Changes

* Draft support for PHP 8, pending compatibility from `php-webdriver/webdriver` and `laravel/dusk`.

## 6.2.1

Released: 2020-10-20

### Fixes

* Fixes missing `$workingPath`.

## 6.2.0

Released: 2020-10-20

### Added

* Added ability to use custom Laravel path for `testbench-dusk` CLI.

## 6.1.0

Released: 2020-10-05

### Added

* Added experimental support for running artisan commands outside of Laravel. e.g:

```
./vendor/bin/testbench-dusk migrate
```

This would allows you to setup the testing environment before running `phpunit` instead of executing everything from within `TestCase::setUp()`.

* Add following folders to Laravel skeleton:
  - `app/Console`
  - `app/Exceptions`
  - `app/Http/Controllers`
  - `app/Http/Middleware`
  - `app/Models`
  - `app/Providers`
  - `database/seeds`

### Changes

* Change default port from `8000` to `8001`.

## 6.0.0

Released: 2020-09-08

### Changes

* Update support for Laravel Framework v8.
* Increase minimum PHP version to 7.3 and above (tested with 7.3 and 7.4).
* Configuration changes:
    - Changed `auth.providers.users.model` to `Illuminate\Foundation\Auth\User`.
    - Changed `queue.failed.driver` to `database-uuid`.
