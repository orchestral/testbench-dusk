# Change for 8.x

This changelog references the relevant changes (bug and security fixes) done to `orchestra/testbench-dusk`.

## 8.1.1

Released: 2023-03-03

### Changes

* Allow to use environment variable `DUSK_HEADLESS_MODE` value (when available).

## 8.1.0

Released: 2023-03-02

### Added

* Allow using `--headless=new` available from Chrome v109.

### Changes

* Update minimum support for Laravel Dusk v7.6.0+. ([v7.5.0...v7.6.0](https://github.com/laravel/dusk/compare/v7.5.0...v7.6.0))

## 8.0.3

Released: 2023-02-24

### Changes

* Update minimum support for Testbench v8.0.3+. ([v8.0.1...v8.0.3](https://github.com/orchestral/testbench/compare/v8.0.1...v8.0.3))

## 8.0.2

Released: 2023-02-17

### Changes

* Update minimum support for Testbench v8.0.1+. ([v8.0.0...v8.0.1](https://github.com/orchestral/testbench/compare/v8.0.0...v8.0.1))

## 8.0.1

Released: 2023-02-16

### Fixes

* Fixes generating `phpunit.dusk.xml` when executing `package:dusk` command on PHPUnit 10.

## 8.0.0

Released: 2023-02-14

### Changes

* Update support for Laravel Framework v10.
* Increase minimum PHP version to 8.1 and above (tested with 8.1 and 8.2).
