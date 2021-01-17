# Change for 5.x

This changelog references the relevant changes (bug and security fixes) done to `orchestra/testbench-dusk`.

## 5.10.0

Released: 2021-01-17

### Changes

* Update minimum support for Testbench v5.13.0+. ([v5.12.1...v5.13.0](https://github.com/orchestral/testbench/compare/v5.12.1...v5.13.0))

## 5.9.0

Released: 2020-12-15

### Changes

* Update minimum support for Testbench v5.12.1+. ([v5.11.0...v5.12.1](https://github.com/orchestral/testbench/compare/v5.11.0...v5.12.1))

## 5.8.0

Released: 2020-12-10

### Changes

* Update minimum support for Testbench v5.11.0+. ([v5.10.0...v5.11.0](https://github.com/orchestral/testbench/compare/v5.10.0...v5.11.0))

## 5.7.0

Released: 2020-12-02

### Changes

* Update minimum support for Testbench v5.10.0+. ([v5.9.0...v5.10.0](https://github.com/orchestral/testbench/compare/v5.9.0...v5.10.0))

## 5.6.0

Released: 2020-11-20

### Changes

* Official support for PHP 8

### Fixes

* Fixes `fsockopen` imcompatible usage on PHP 8.

## 5.5.0

Released: 2020-11-07

### Changes

* Draft support for PHP 8, pending compatibility from `php-webdriver/webdriver` and `laravel/dusk`.

## 5.4.1

Released: 2020-10-20

### Fixes

* Fixes missing `$workingPath`.

## 5.4.0 

Released: 2020-10-20

### Added

* Added ability to use custom Laravel path for `testbench-dusk` CLI.

## 5.3.0

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
  - `app/Providers`
  - `database/seeds`

### Changes

* Change default port from `8000` to `8001`.

## 5.2.0

Released: 2020-05-05

### Changes

* Add support for `laravel/dusk` v6+.
* Update minimum support for Testbench v5.2.0+. ([v5.1.0...v5.2.0](https://github.com/orchestral/testbench/compare/v5.1.0...v5.2.0))
* Update Laravel 7.x skeleton:
    - Add `mail.mailers.stmp.auth_mode` configuration.

## 5.1.3

Released: 2020-04-11

### Changes

* Update Laravel 7.x skeleton.

## 5.1.2

Released: 2020-04-02

### Changes

* Update Laravel 7.x skeleton:
    - Rename `filesystems.disk.s3.url` to `filesystems.disk.s3.endpoint`.

## 5.1.1

Released: 2020-03-16

### Changes

* Update Laravel 7.x skeleton.
    - Update `cors.exposed_headers` and `cors.max_age` default configuration value.
    - Add `mailers.smtp.timeout` configuration options.
    - Update `session` configuration file.

## 5.1.0

Released: 2020-03-11

### Changes

* Update minimum support for Testbench v5.1.0+. ([v5.0.2...v5.1.0](https://github.com/orchestral/testbench/compare/v5.0.2...v5.1.0))

## 5.0.2

Released: 2020-03-07

### Changes

* Update Laravel 7.x skeleton.
    - Cast `app.debug` value to `boolean`.
    - Add `queue.connections.sqs.suffix` configuration, use `SQS_SUFFIX` from environment variable.
    - Remove `view.expires`, feature has been reverted.
* Update minimum support for Testbench v5.0.2+. ([v5.0.1...v5.0.2](https://github.com/orchestral/testbench/compare/v5.0.1...v5.0.2))

## 5.0.1

Released: 2020-03-03

### Changes

* Update minimum support for Testbench v5.0.1+. ([v5.0.0...v5.0.1](https://github.com/orchestral/testbench/compare/v5.0.0...v5.0.1))

## 5.0.0

Released: 2020-03-02

### Changes

* Update Laravel 7 skeleton:
    - Rename default `Redis` alias under `app.aliases` to `RedisManager` to avoid incompatibility when running tests using `phpredis` extension.
    - Add `Http` alias under `app.aliases`.
    - Add `config/cors.php`.
    - Update `database`, `filesystem`, `mail`, `session` and `view` configuration file.
