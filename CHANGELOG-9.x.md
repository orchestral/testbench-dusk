# Changes for 9.x

This changelog references the relevant changes (bug and security fixes) done to `orchestra/testbench-dusk`.

## 9.8.0

Released: 2024-09-25

### Changes

* Update minimum support for Testbench v9.5.0+. ([v9.4.0...v9.5.0](https://github.com/orchestral/testbench/compare/v9.4.0...v9.5.0))
* Update minimum support for Testbench Core v9.5.1+. ([v9.4.0...v9.5.1](https://github.com/orchestral/testbench-core/compare/v9.4.0...v9.5.1))
* Update `Orchestra\Testbench\default_skeleton_path()` to accept `array`.

### Removed

* Removed `Orchestra\Testbench\Dusk\find_test_directory()` function.

## 9.7.1

Released: 2024-09-12

### Changes

* Add `concurrency.php` configuration based on Laravel Framework 11.23.

## 9.7.0

Released: 2024-08-26

### Added

* Added `Orchestra\Testbench\Dusk\TestCase::$chromeDriverPort` property with `9515` port as default.

### Changes

* Update minimum support for Testbench v9.4.0+. ([v9.3.0...v9.4.0](https://github.com/orchestral/testbench/compare/v9.3.0...v9.4.0))
* Update minimum support for Testbench Core v9.4.0+. ([v9.3.0...v9.4.0](https://github.com/orchestral/testbench-core/compare/v9.3.0...v9.4.0))
* Utilise `Orchestra\Testbench\join_paths()` function.
* Use `Laravel\SerializableClosure\SerializableClosure::unsigned()`.

## 9.6.0

Released: 2024-08-14

### Changes

* Update minimum support for Testbench v9.3.0+. ([v9.2.0...v9.3.0](https://github.com/orchestral/testbench/compare/v9.2.0...v9.3.0))
* Update minimum support for Testbench Core v9.3.0+. ([v9.2.1...v9.3.0](https://github.com/orchestral/testbench-core/compare/v9.2.1...v9.3.0))

## 9.5.0

Released: 2024-07-30

### Added

* Added `Orchestra\Testbench\Dusk\Options::fullscreen()` helper method.
* Added `--disable-search-engine-choice-screen` as default argument to ChromeOptions.

### Changes

* Bump minimum Dusk Updater versions to support ChromeDriver 127 and above.

## 9.4.0

Released: 2024-07-13

### Added

* Added `Orchestra\Testbench\Dusk\Options::using()` method to interacts with `Facebook\WebDriver\Chrome\ChromeOptions`.

### Changes

* Update minimum support for Testbench v9.2.0+. ([v9.1.2...v9.2.0](https://github.com/orchestral/testbench/compare/v9.1.2...v9.2.0))
* Update minimum support for Testbench Core v9.2.1+. ([v9.1.3...v9.2.1](https://github.com/orchestral/testbench-core/compare/v9.1.3...v9.2.1))

## 9.3.1

Released: 2024-06-28

### Changes

* Update minimum support for Testbench v9.1.2+. ([v9.1.1...v9.1.2](https://github.com/orchestral/testbench/compare/v9.1.1...v9.1.2))
* Update minimum support for Testbench Core v9.1.3+. ([v9.1.2...v9.1.3](https://github.com/orchestral/testbench-core/compare/v9.1.2...v9.1.3))
* Provide Process's `$commandline` as `array` to leverage `proc_open()` on Symfony Process 7.1.

## 9.3.0

Released: 2024-06-02

### Changes

* Update minimum support for Testbench v9.1.1+. ([v9.1.0...v9.1.1](https://github.com/orchestral/testbench/compare/v9.1.0...v9.1.1))
* Update minimum support for Testbench Core v9.1.2+. ([v9.1.0...v9.1.2](https://github.com/orchestral/testbench-core/compare/v9.1.0...v9.1.2))
* Update configuration to match Laravel Framework v11.8.0.

## 9.2.0

Released: 2024-05-21

### Changes

* Update minimum support for Testbench v9.1.0+. ([v9.0.3...v9.1.0](https://github.com/orchestral/testbench/compare/v9.0.3...v9.1.0))
* Update minimum support for Testbench Core v9.1.0+. ([v9.0.9...v9.1.0](https://github.com/orchestral/testbench-core/compare/v9.0.9...v9.1.0))
* Uses `TESTBENCH_WORKING_PATH` from environment variable before fallback to `getcwd()`.
* PHPStan Improvements.

## 9.1.2

Released: 2024-05-09

### Changes

* Update skeleton to match v11.0.7.

## 9.1.1

Released: 2024-04-07

### Changes

* Append `APP_ENV`, `TESTBENCH_PACKAGE_TESTER`, `TESTBENCH_WORKING_PATH` and `TESTBENCH_APP_BASE_PATH` to `package:dusk` command.

## 9.1.0

Released: 2024-03-31

### Added

* Add `defineChromeDriver()` method by @joshhanley in [#94](https://github.com/orchestral/testbench-dusk/pull/94).

<!--
#### New Contributors
* @joshhanley made their first contribution in https://github.com/orchestral/testbench-dusk/pull/94
-->

## 9.0.2

Released: 2024-03-29

### Changes

* Update minimum support for Testbench v9.0.3+. ([v9.0.0...v9.0.3](https://github.com/orchestral/testbench/compare/v9.0.0...v9.0.3))
* Update minimum support for Testbench Core v9.0.9+. ([v9.0.4...v9.0.9](https://github.com/orchestral/testbench-core/compare/v9.0.4...v9.0.9))

## 9.0.1

Released: 2024-03-18

### Changes

* Update minimum support for Testbench Core v9.0.4+. ([v9.0.0...v9.0.4](https://github.com/orchestral/testbench-core/compare/v9.0.0...v9.0.4))
* Update skeleton to match v11.0.4.

## 9.0.0

Released: 2024-03-13

### Changes

* Update support for Laravel Framework v11.
* Update minimum support for Testbench v9.0.0+. ([v8.22.0...v9.0.0](https://github.com/orchestral/testbench/compare/v8.22.0...v9.0.0))
* Update minimum support for Laravel Dusk v8.0.0+. ([v7.13.0...v8.0.0](https://github.com/laravel/dusk/compare/v7.13.0...v8.0.0))
* Increase minimum PHP version to 8.2 and above (tested with 8.2 and 8.3).
