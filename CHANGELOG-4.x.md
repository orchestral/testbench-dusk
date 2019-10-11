# Change for 4.x

This changelog references the relevant changes (bug and security fixes) done to `orchestra/testbench-dusk`.

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

