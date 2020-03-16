# Change for 5.x

This changelog references the relevant changes (bug and security fixes) done to `orchestra/testbench-dusk`.

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
