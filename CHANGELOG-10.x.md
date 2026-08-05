# Changes for 10.x

This changelog references the relevant changes (bug and security fixes) done to `orchestra/testbench-dusk`.

## 10.11.0

Released: 2026-08-05

### Changes

* Update minimum support for Testbench v10.11.0+. ([v10.10.0...v10.11.0](https://github.com/orchestral/testbench/compare/v10.10.0...v10.11.0))
* Update minimum support for Testbench Core v10.14.1+. ([v10.10.0...v10.14.1](https://github.com/orchestral/testbench/compare/v10.10.0...v10.14.1))
* Prevents `Orchestra\Testbench\Dusk\DuskServer` hang when `php -S` pipe fills.

## 10.10.0

Released: 2026-03-16

### Changes

* Update minimum support for Testbench v10.10.0+. ([v10.9.0...v10.10.0](https://github.com/orchestral/testbench/compare/v10.9.0...v10.10.0))

## 10.9.0

Released: 2026-01-14

### Changes

* Update minimum support for Testbench v10.9.0+. ([v10.8.0...v10.9.0](https://github.com/orchestral/testbench/compare/v10.8.0...v10.9.0))

## 10.8.0

Released: 2025-12-08

### Changes

* Update minimum support for Testbench v10.8.0+. ([v10.7.0...v10.8.0](https://github.com/orchestral/testbench/compare/v10.7.0...v10.8.0))
* PHP 8.5 Compatibility.

## 10.7.0

Released: 2025-12-08

### Changes

* Update minimum support for Testbench v10.7.0+. ([v10.6.0...v10.7.0](https://github.com/orchestral/testbench/compare/v10.6.0...v10.7.0))

## 10.6.0

Released: 2025-08-21

### Changes

* Update minimum support for Testbench v10.6.0+. ([v10.5.0...v10.6.0](https://github.com/orchestral/testbench/compare/v10.5.0...v10.6.0))

## 10.5.0

Released: 2025-08-21

### Changes

* Update minimum support for Testbench v10.5.0+. ([v10.4.0...v10.5.0](https://github.com/orchestral/testbench/compare/v10.4.0...v10.5.0))
* Update minimum support for Testbench Core v10.6.1+. ([v10.4.0...v10.6.1](https://github.com/orchestral/testbench/compare/v10.4.0...v10.6.1))

## 10.4.0

Released: 2025-06-08

### Changes

* Update minimum support for Testbench v10.4.0+. ([v10.3.0...v10.4.0](https://github.com/orchestral/testbench/compare/v10.3.0...v10.4.0))
* Update minimum support for Testbench Core v10.4.0+. ([v10.3.0...v10.4.0](https://github.com/orchestral/testbench/compare/v10.3.0...v10.4.0))

## 10.3.0

Released: 2025-05-12

### Changes

* Update minimum support for Testbench v10.3.0+. ([v10.2.2...v10.3.0](https://github.com/orchestral/testbench/compare/v10.2.2...v10.3.0))
* Update minimum support for Testbench Core v10.3.0+. ([v10.2.2...v10.3.0](https://github.com/orchestral/testbench/compare/v10.2.2...v10.3.0))

## 10.2.2

Released: 2025-04-27

### Changes

* Update minimum support for Testbench v10.2.2+. ([v10.2.1...v10.2.2](https://github.com/orchestral/testbench/compare/v10.2.1...v10.2.2))
* Update minimum support for Testbench Core v10.2.2+. ([v10.2.1...v10.2.2](https://github.com/orchestral/testbench/compare/v10.2.1...v10.2.2))

## 10.2.1

Released: 2025-04-13

### Changes

* Update minimum support for Testbench v10.2.1+. ([v10.2.0...v10.2.1](https://github.com/orchestral/testbench/compare/v10.2.0...v10.2.1))
* Update minimum support for Testbench Core v10.2.1+. ([v10.2.0...v10.2.1](https://github.com/orchestral/testbench/compare/v10.2.0...v10.2.1))
* Remove `symfony/polyfill-php84`.

## 10.2.0

Released: 2025-04-06

### Changes

* Update minimum support for Testbench v10.2.0+. ([v10.1.0...v10.2.0](https://github.com/orchestral/testbench/compare/v10.1.0...v10.2.0))
* Update minimum support for Testbench Core v10.2.0+. ([v10.1.0...v10.2.0](https://github.com/orchestral/testbench/compare/v10.1.0...v10.2.0))
* Add supports for PHPUnit 12.0 and 12.1.

### Deprecated

* Deprecate `tweakApplication()` method and use `beforeServingApplication()` method instead.
* Deprecate `removeApplicationTweaks()` method and use `afterServingApplication()` method instead.

## 10.1.0

Released: 2025-03-06

### Changes

* Update minimum support for Testbench v10.1.0+. ([v10.0.0...v10.1.0](https://github.com/orchestral/testbench/compare/v10.0.0...v10.1.0))
* Update minimum support for Testbench Core v10.1.0+. ([v10.0.0...v10.1.0](https://github.com/orchestral/testbench/compare/v10.0.0...v10.1.0))
* Improves vendor detection on the default skeleton.

## 10.0.3

Released: 2025-02-25

### Changes

* Ensure `--disable-search-engine-choice-screen` and `--disable-smooth-scrolling` options applied by default.

## 10.0.2

Released: 2025-02-24

### Changes

* Update skeleton's configuration and welcome page.

## 10.0.1

Released: 2025-02-19

### Changes

* Use `orchestra/sidekick`.

## 10.0.0

Released: 2025-02-16

### Changes

* Update support for Laravel Framework v12.
* Update minimum support for Testbench v10.0.0+. ([v9.10.0...v10.0.0](https://github.com/orchestral/testbench/compare/v9.10.0...v10.0.0))
* Update minimum support for Testbench Core v10.0.0+. ([v9.10.0...v10.0.0](https://github.com/orchestral/testbench/compare/v9.10.0...v10.0.0))
* Update minimum support for Laravel Dusk v8.2.14+. ([v8.1.0...v8.2.14](https://github.com/laravel/dusk/compare/v8.1.0...v8.2.14))

### Removed

* Remove deprecated `getDefaultApplicationBootstrapFile()` method.
