# Change for 4.x

This changelog references the relevant changes (bug and security fixes) done to `orchestra/testbench-dusk`.

## 4.16.0

Released: 2021-02-09

### Changes

* Update minimum support for Testbench v4.16.0+. ([v4.14.0...v4.16.0](https://github.com/orchestral/testbench/compare/v4.14.0...v4.16.0))

## 4.15.0

Released: 2021-02-09

### Changes

* Update minimum support for Testbench v4.15.0+. ([v4.14.0...v4.15.0](https://github.com/orchestral/testbench/compare/v4.14.0...v4.15.0))
* Update list of available methods on `Orchestra\Testbench\Dusk\Options`.
* Automatically set `--headless` when environment variable contains `CI=true`.

## 4.14.0

Released: 2021-01-17

### Changes

* Update minimum support for Testbench v4.14.0+. ([v4.13.0...v4.14.0](https://github.com/orchestral/testbench/compare/v4.13.0...v4.14.0))

## 4.13.0

Released: 2020-12-15

### Changes

* Update minimum support for Testbench v4.13.0+. ([v4.12.2...v4.13.0](https://github.com/orchestral/testbench/compare/v4.12.2...v4.13.0))

## 4.12.0

Released: 2020-12-10

### Changes

* Update minimum support for Testbench v4.12.2+. ([v4.11.0...v4.12.2](https://github.com/orchestral/testbench/compare/v4.11.0...v4.12.2))

## 4.11.0

Released: 2020-12-02

### Changes

* Update minimum support for Testbench v4.11.0+. ([v4.7.0...v4.11.0](https://github.com/orchestral/testbench/compare/v4.7.0...v4.11.0))

## 4.10.0

Released: 2020-11-20

### Changes

* Official support for PHP 8

### Fixes

* Fixes `fsockopen` imcompatible usage on PHP 8.

## 4.9.0

Released: 2020-11-07

### Added

* Added `Orchestra\Testbench\Dusk\TestCase::baseServeUrl()` helper method.
 
### Changes

* Draft support for PHP 8, pending compatibility from `php-webdriver/webdriver` and `laravel/dusk`.
* Improves support for custom skeleton laravel.

## 4.8.1

Released: 2020-04-11

### Changes

* Update Laravel 6.x skeleton.

## 4.8.0

Released: 2020-03-07

### Changes

* Update minimum support for Testbench v4.7.0+. ([v4.6.0...v4.7.0](https://github.com/orchestral/testbench/compare/v4.6.0...v4.7.0))

## 4.7.0

Released: 2020-01-30

### Changes

* Update minimum support for Testbench v4.6.0+. ([v4.5.0...v4.6.0](https://github.com/orchestral/testbench/compare/v4.5.0...v4.6.0))

## 4.6.0

Released: 2020-01-24

### Changes

* Update skeleton.
* Replace deprecated `facebook/webdriver` with `php-webdriver/webdriver`. 
* Update `opis/closure`, avoid `Opis\Closure\ClosureStream::stream_set_option` is not implemented on PHP 7.4 with `--prefer-lowest` setup.

## 4.5.0

Released: 2020-01-08

### Changes

* Update skeleton.
* Update minimum support for Testbench v4.5.0+. ([v4.4.1...v4.5.0](https://github.com/orchestral/testbench/compare/v4.4.1...v4.5.0))

## 4.4.1

Released: 2019-12-17

### Added

* Add `storage/app/public` folder on skeleton directory.

### Changes

* Update skeleton.

## 4.4.0

Released: 2019-11-24

### Changes

* Update minimum support for Testbench v4.4.1+. ([v4.3.0...v4.4.1](https://github.com/orchestral/testbench/compare/v4.3.0...v4.4.1))

## 4.3.0

Released: 2019-10-24

### Changes

* Update minimum support for Testbench v4.3.0+. ([v4.2.0...v4.3.0](https://github.com/orchestral/testbench/compare/v4.2.0...v4.3.0))

## 4.2.0

Released: 2019-10-11

### Changes

* Update minimum support for Testbench v4.2.0+. ([v4.1.0...v4.2.0](https://github.com/orchestral/testbench/compare/v4.1.0...v4.2.0))

## 4.1.0 

Released: 2019-10-06

### Changes

* Update minimum support for Testbench v4.1.0+. ([v4.0.1...v4.1.0](https://github.com/orchestral/testbench/compare/v4.0.1...v4.1.0))
* Rename default `Redis` alias under `app.aliases` to `RedisManager` to avoid incompatibility when running tests using `phpredis` extension.

## 4.0.2

Released: 2019-09-15

### Changes

* Update Laravel 6 skeleton:
    - Add `logging.channels.null` configuration.
    - Revert Argon2 memory configuration made in v4.0.1.

## 4.0.1

Released: 2019-09-11

### Changes

* Update Laravel 6 skeleton.

## 4.0.0

Released: 2019-09-03

### Changes

* Update support for Laravel Framework v6.0.
* Increase minimum PHP version to 7.2+ (tested with 7.2 and 7.3).
* Increase minimum PHPUnit to v8.0+.
* Configuration changes:
    - `REDIS_CLIENT` now defaults to `phpredis`.
    - `REDIS_CLUSTER` now defaults to `redis`.

### Breaking Changes

* Any tests requiring Redis would now requires `ext-redis` to be installed. As of now you either can setup Redis or set `REDIS_CLIENT` and `REDIS_CLUSTER` to the deprecated `predis` option.

