# Changes for 7.x

This changelog references the relevant changes (bug and security fixes) done to `orchestra/testbench-dusk`.

## 7.39.0

Released: 2024-01-19

### Added

* Added `Orchestra\Testbench\Dusk\default_skeleton_path()` helper function.

### Changes

* Update minimum support for Testbench v7.40.0+. ([v7.39.0...v7.40.0](https://github.com/orchestral/testbench/compare/v7.39.0...v7.40.0))
* Increase server timeout to `6000` seconds instead of `60` seconds.
* Clear `$server` static method during `tearDownAfterClass`.

## 7.38.0

Released: 2023-12-28

### Changes

* Update minimum support for Testbench v7.39.0+. ([v7.38.0...v7.39.0](https://github.com/orchestral/testbench/compare/v7.38.0...v7.39.0))
* Update minimum support for Laravel Dusk v7.12.0+. ([v7.11.3...v7.12.0](https://github.com/laravel/dusk/compare/v7.11.3...v7.12.0))

## 7.37.0

Released: 2023-12-19

### Changes

* Update minimum support for Testbench v7.38.0+. ([v7.37.0...v7.38.0](https://github.com/orchestral/testbench/compare/v7.37.0...v7.38.0))

## 7.36.0

Released: 2023-12-06

### Changes

* Update minimum support for Testbench v7.37.0+. ([v7.36.0...v7.37.0](https://github.com/orchestral/testbench/compare/v7.36.0...v7.37.0))

## 7.35.0

Released: 2023-12-04

### Added

* Added the following attributes:
  - `Orchestra\Testbench\Dusk\Attributes\BeforeServing`
  - `Orchestra\Testbench\Dusk\Attributes\RestartServer`
* Backport `startServing()` and `reloadServing()` to `Orchestra\Testbench\Dusk\CanServeSite` trait.
* Add `createServingApplicationForDuskServer` method to `Orchestra\Testbench\Dusk\CanServeSite` trait.

### Changes

* Update minimum support for Testbench v7.36.0+. ([v7.35.0...v7.36.0](https://github.com/orchestral/testbench/compare/v7.35.0...v7.36.0))
* Allow passing method name to `Orchestra\Testbench\Dusk\CanServeSite::beforeServingApplication()` method.

### Deprecated

* Deprecate `getFreshApplicationToServe` method on `Orchestra\Testbench\Dusk\CanServeSite` trait, use `createServingApplicationForDuskServer` instead.

## 7.34.0

Released: 2023-11-10

### Changes

* Update minimum support for Testbench v7.35.0+. ([v7.34.0...v7.35.0](https://github.com/orchestral/testbench/compare/v7.34.0...v7.35.0))
* Refactor `Orchetra\Testbench\Dusk\DuskServer`.

## 7.33.0

Released: 2023-10-24

### Changes

* Update minimum support for Testbench v7.34.0+. ([v7.32.0...v7.34.0](https://github.com/orchestral/testbench/compare/v7.32.0...v7.34.0))
* Update minimum support for Laravel Dusk v7.11.3+. ([v7.5.0...v7.11.3](https://github.com/laravel/dusk/compare/v7.5.0...v7.11.3))

## 7.32.2

Released: 2023-09-30

### Fixes

* Fixes forwarding environment variables using `Env::forward()`.

## 7.32.1

Released: 2023-09-27

### Changes

* Code refactors.

## 7.32.0

Released: 2023-09-26

### Changes

* Update minimum support for Testbench v7.32.0+. ([v7.30.0...v7.32.0](https://github.com/orchestral/testbench/compare/v7.30.0...v7.32.0))
* Improves integration with `Orchestra\Testbench\Concerns\WithWorkbench` trait.
* Use `Orchestra\Testbench\Foundation\Env::forward()` to handle sending environment variables via Symfony Process.

## 7.31.0

Released: 2023-08-29

### Changes

* Update minimum support for Testbench v7.30.0+. ([v7.29.1...v7.30.0](https://github.com/orchestral/testbench/compare/v7.29.1...v7.30.0))

## 7.30.1

Released: 2023-08-23

### Fixes

* Fixes usage with `Orchestra\Testbench\Concerns\WithWorkbench`.

## 7.30.0

Released: 2023-08-22

### Added

* Added `Orchestra\Testbench\Dusk\Concerns\InteractsWithWebDriverOptions`.

### Changes

* Update minimum support for Testbench v7.29.1+. ([v7.29.0...v7.29.1](https://github.com/orchestral/testbench/compare/v7.29.0...v7.29.1))
* Utilise `setUpTheTestEnvironmentTraitToBeIgnored()` method.

## 7.29.0

Released: 2023-08-15

### Changes

* Update minimum support for Testbench v7.29.0+. ([v7.28.0...v7.29.0](https://github.com/orchestral/testbench/compare/v7.28.0...v7.29.0))
* Use `Symfony\Component\Console\Attribute\AsCommand` attribute.

## 7.28.0

Released: 2023-08-15

### Changes

* Update minimum support for Testbench v7.28.0+. ([v7.26.2...v7.28.0](https://github.com/orchestral/testbench/compare/v7.26.2...v7.28.0))
* Update `laravel/bootstrap/app.php` to match `orchestra/testbench-core`.

## 7.27.1

Released: 2023-08-10

### Changes

* Update minimum support for Testbench v7.26.2+. ([v7.26.0...v7.26.2](https://github.com/orchestral/testbench/compare/v7.26.0...v7.26.2))

## 7.27.0

Released: 2023-08-08

### Changes

* Update minimum support for Testbench v7.26.0+. ([v7.25.0...v7.26.0](https://github.com/orchestral/testbench/compare/v7.25.0...v7.26.0))
* Autoload `Laravel\Dusk\DuskServiceProvider` service provider.

## 7.26.1

Released: 2023-07-25

### Fixes

* Fixes running `DuskServer` on certain environment where PHP executable path need to be wrapped using quote.

## 7.26.0

Released: 2023-07-22

### Changes

* Update minimum support for Testbench v7.25.0+. ([v7.24.1...v7.25.0](https://github.com/orchestral/testbench/compare/v7.24.1...v7.25.0))
* Update `orchestra/dusk-updater` to support ChromeDriver `115`+.

## 7.25.1

Released: 2023-04-03

### Changes

* Update minimum support for Testbench v7.24.1+. ([v7.24.0...v7.24.1](https://github.com/orchestral/testbench/compare/v7.24.0...v7.24.1))

## 7.25.0

Released: 2023-04-01

### Changes

* Update minimum support for Testbench v7.24.0+. ([v7.23.0...v7.24.0](https://github.com/orchestral/testbench/compare/v7.23.0...v7.24.0))

## 7.24.0

Released: 2023-03-27

### Changes

* Update minimum support for Testbench v7.23.0+. ([v7.22.1...v7.23.0](https://github.com/orchestral/testbench/compare/v7.22.1...v7.23.0))

## 7.23.0

Released: 2023-03-03

### Added

* Allow using `--headless=new` available from Chrome v109 using environment variable `DUSK_HEADLESS_MODE` value (when available).

### Changes

* Update minimum support for Laravel Dusk v7.7.0+. ([v7.5.0...v7.7.0](https://github.com/laravel/dusk/compare/v7.5.0...v7.7.0))

## 7.22.1

Released: 2023-02-24

### Changes

* Update minimum support for Testbench v7.22.1+. ([v7.22.0...v7.22.1](https://github.com/orchestral/testbench/compare/v7.22.0...v7.22.1))

## 7.22.0

Released: 2023-02-08

### Changes

* Update minimum support for Testbench v7.22.0+. ([v7.21.0...v7.22.0](https://github.com/orchestral/testbench/compare/v7.21.0...v7.22.0))

## 7.21.0

Released: 2023-02-03

### Changes

* Update minimum support for Testbench v7.21.0+. ([v7.20.0...v7.21.0](https://github.com/orchestral/testbench/compare/v7.20.0...v7.21.0))

## 7.20.0

Released: 2023-02-01

### Changes

* Allow using environment variable `DUSK_DRIVER_URL` value (when available).
* Update minimum support for Testbench v7.20.0+. ([v7.19.0...v7.20.0](https://github.com/orchestral/testbench/compare/v7.19.0...v7.20.0))
* Update minimum support for Laravel Dusk v7.5.0+. ([v7.3.0...v7.5.0](https://github.com/laravel/dusk/compare/v7.3.0...v7.5.0))

## 7.19.0

Released: 2023-01-10

### Changes

* Update minimum support for Testbench v7.19.0+. ([v7.18.0...v7.19.0](https://github.com/orchestral/testbench/compare/v7.18.0...v7.19.0))

## 7.18.0

Released: 2023-01-03

### Changes

* Update minimum support for Testbench v7.18.0+. ([v7.17.0...v7.18.0](https://github.com/orchestral/testbench/compare/v7.17.0...v7.18.0))
* Update minimum support for Laravel Dusk v7.3.0+. ([v7.2.1...v7.3.0](https://github.com/laravel/dusk/compare/v7.2.1...v7.3.0))

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
