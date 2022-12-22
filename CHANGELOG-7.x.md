# Change for 7.x

This changelog references the relevant changes (bug and security fixes) done to `orchestra/testbench-dusk`.

## 7.17.0

Released: 2022-12-22

### Changes

* Update minimum support for Testbench v7.17.0+. ([v7.16.0...v7.17.0](https://github.com/orchestral/testbench/compare/v7.16.0...v7.17.0))

## 7.16.0

Released: 2022-12-17

### Changes

* Update minimum support for Testbench v7.16.0+. ([v7.15.0...v7.16.0](https://github.com/orchestral/testbench/compare/v7.15.0...v7.16.0))
* Update minimum support for Laravel Dusk v7.2.1+. ([v7.0.0...v7.2.1](https://github.com/laravel/dusk/compare/v7.0.0...v7.2.1))

## 7.15.0

Released: 2022-11-30

### Changes

* Update minimum support for Testbench v7.15.0+. ([v7.14.1...v7.15.0](https://github.com/orchestral/testbench/compare/v7.14.1...v7.15.0))

## 7.14.1

Released: 2022-11-29

### Changes

* Update minimum support for Testbench v7.14.1+. ([v7.14.0...v7.14.1](https://github.com/orchestral/testbench/compare/v7.14.0...v7.14.1))

## 7.14.0

Released: 2022-11-23

### Changes

* Update minimum support for Testbench v7.14.0+. ([v7.13.0...v7.14.0](https://github.com/orchestral/testbench/compare/v7.13.0...v7.14.0))

## 7.13.0

Released: 2022-11-14

### Changes

* Update minimum support for Testbench v7.13.0+. ([v7.12.1...v7.13.0](https://github.com/orchestral/testbench/compare/v7.12.1...v7.13.0))

## 7.12.1

Released: 2022-11-12

### Changes

* Update minimum support for Testbench v7.12.1+. ([v7.12.0...v7.12.1](https://github.com/orchestral/testbench/compare/v7.12.0...v7.12.1))

### Fixes

* Fixes where the default database connection as `sqlite` causes an exception when the database file isn't available. The loaded application should revert to `testing` database connection for the state.

## 7.12.0

Released: 2022-11-12

### Added

* Added support for `about` artisan command.
* Added `package:devtool` to generate `.env`, `testbench.yaml` and `database.sqlite` file.
* Added `package:create-sqlite-db` and `package:drop-sqlite-db` command.
* Improves support for `serve` command.

### Changes

* Update minimum support for Testbench v7.12.0+. ([v7.11.0...v7.12.0](https://github.com/orchestral/testbench/compare/v7.11.0...v7.12.0))

## 7.11.0

Released: 2022-10-19

### Changes

* Update minimum support for Testbench v7.11.0+. ([v7.10.2...v7.11.0](https://github.com/orchestral/testbench/compare/v7.10.2...v7.11.0))

## 7.10.2

Released: 2022-10-15

### Changes

* Update minimum support for Testbench v7.10.2+. ([v7.10.1...v7.10.2](https://github.com/orchestral/testbench/compare/v7.10.1...v7.10.2))

## 7.10.1

Released: 2022-10-11

### Changes

* Update minimum support for Testbench v7.10.1+. ([v7.10.0...v7.10.1](https://github.com/orchestral/testbench/compare/v7.10.0...v7.10.1))

## 7.10.0

Released: 2022-10-11

### Added

* Added `startServing()` and `reloadServing()` method to `Orchestra\Testbench\Dusk\Concerns\CanServeSite` trait.

### Changes

* Update minimum support for Testbench v7.10.0+. ([v7.9.0...v7.10.0](https://github.com/orchestral/testbench/compare/v7.9.0...v7.10.0))

## 7.9.0

Released: 2022-10-05

### Added

* Added draft support for PHP 8.2.

### Changes

* Update minimum support for Testbench v7.9.0+. ([v7.8.1...v7.9.0](https://github.com/orchestral/testbench/compare/v7.8.1...v7.9.0))

## 7.8.1

Released: 2022-10-04

### Changes

* Update minimum support for Testbench v7.8.1+. ([v7.8.0...v7.8.1](https://github.com/orchestral/testbench/compare/v7.8.0...v7.8.1))

## 7.8.0

Released: 2022-09-28

### Added

* Added `getBaseServePort()` and `getBaseServeHost()` method to `Orchestra\Testbench\Dusk\TestCase`.

### Changes

* Update minimum support for Testbench v7.8.0+. ([v7.7.1...v7.8.0](https://github.com/orchestral/testbench/compare/v7.7.1...v7.8.0))
* Improves PHPUnit memory leaks.

## 7.7.1

Released: 2022-09-28

### Changes

* Update minimum support for Testbench v7.7.1+. ([v7.7.0...v7.7.1](https://github.com/orchestral/testbench/compare/v7.7.0...v7.7.1))

## 7.7.0

Released: 2022-08-24

### Added

* Added support for Laravel Dusk v7.0+.

### Changes

* Update minimum support for Testbench v7.7.0+. ([v7.6.1...v7.7.0](https://github.com/orchestral/testbench/compare/v7.6.1...v7.7.0))

## 7.6.1

Released: 2022-08-10

### Changes

* Update minimum support for Testbench v7.6.1+. ([v7.6.0...v7.6.1](https://github.com/orchestral/testbench/compare/v7.6.0...v7.6.1))
* Update minimum support for Laravel Dusk v6.25.1+. ([v6.24.0...v6.25.1](https://github.com/laravel/dusk/compare/v6.24.0...v6.25.1))

## 7.6.0

Released: 2022-06-30

### Changes

* Update minimum support for Testbench Core v7.6.0+. ([v7.5.0...v7.6.0](https://github.com/orchestral/testbench-core/compare/v7.5.0...v7.6.0))

## 7.5.0

Released: 2022-05-11

### Changes

* Update minimum support for Testbench v7.5.0+. ([v7.4.0...v7.5.0](https://github.com/orchestral/testbench/compare/v7.4.0...v7.5.0))
* Update minimum support for Laravel Dusk v6.24.0+. ([v6.23.0...v6.24.0](https://github.com/laravel/dusk/compare/v6.23.0...v6.24.0))

## 7.4.0

Released: 2022-04-13

### Changes

* Update minimum support for Testbench v7.4.0+. ([v7.3.0...v7.4.0](https://github.com/orchestral/testbench/compare/v7.3.0...v7.4.0))
* Update minimum support for Laravel Dusk v6.23.0+. ([v6.22.2...v6.23.0](https://github.com/laravel/dusk/compare/v6.22.2...v6.23.0))

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
