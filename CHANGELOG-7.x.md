# Change for 7.x

This changelog references the relevant changes (bug and security fixes) done to `orchestra/testbench-dusk`.

## 7.3.0

Released: 2022-04-02

### Changes

* Update minimum support for Testbench v7.3.0+. ([v7.2.0...v7.3.0](https://github.com/orchestral/testbench/compare/v7.2.0...v7.3.0))
* Update minimum support for Laravel Dusk v6.22.2+. ([v6.22.1...v6.22.2](https://github.com/laravel/dusk/compare/v6.22.1...v6.22.2))

## 7.2.0

Released: 2022-02-1

### Changes

* Update minimum support for Testbench v7.2.0+. ([v7.1.0...v7.2.0](https://github.com/orchestral/testbench/compare/v7.1.0...v7.2.0))

## 7.1.0

Released: 2022-02-23

### Changes

* Update minimum support for Testbench v7.1.0+. ([v7.0.2...v7.1.0](https://github.com/orchestral/testbench/compare/v7.0.2...v7.1.0))

## 7.0.2

Released: 2022-02-16

### Changes

* Update minimum support for Testbench v7.0.2+. ([v7.0.1...v7.0.2](https://github.com/orchestral/testbench/compare/v7.0.1...v7.0.2))
* Update minimum support for Laravel Dusk v6.22.1+. ([v6.21.0...v6.22.1](https://github.com/laravel/dusk/compare/v6.21.0...v6.22.1))

## 7.0.1

Released: 2022-02-14

### Changes

* Update minimum support for Testbench v7.0.1+. ([v7.0.0...v7.0.1](https://github.com/orchestral/testbench/compare/v7.0.0...v7.0.1))
* Add missing `lang/en.json` skeleton file.

## 7.0.0

Released: 2022-02-08

### Changes

* Update support for Laravel Framework v9.
* Increase minimum PHP version to 8.0 and above (tested with 8.0 and 8.1).
* Following internal `Orchestra\Testbench\Dusk\Bootstrap\LoadConfiguration` class has been marked as `final`.
* Moved `resources/lang` skeleton files to `lang` directory.

### Removed

* Removed deprecated `Orchestra\Testbench\Dusk\TestCase::baseUrl()`, use `applicationBaseUrl()` instead.
