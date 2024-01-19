# Changes for 8.x

This changelog references the relevant changes (bug and security fixes) done to `orchestra/testbench-dusk`.

## 8.21.0

Released: 2024-01-19

### Added

* Added `Orchestra\Testbench\Dusk\default_skeleton_path()` helper function.

### Changes

* Update minimum support for Testbench v7.40.0+. ([v7.39.0...v7.40.0](https://github.com/orchestral/testbench/compare/v7.39.0...v7.40.0))
* Increase server timeout to `6000` seconds instead of `60` seconds.
* Clear `$server` static method during `tearDownAfterClass`.

## 8.20.0

Released: 2024-01-10

### Added

* Added `DUSK_SERVE_HOST` and `DUSK_SERVE_PORT` environment variables.

### Changes

* Update minimum support for Testbench v8.20.0+. ([v8.19.0...v8.20.0](https://github.com/orchestral/testbench/compare/v8.19.0...v8.20.0))
* Ignores `beforeServingApplication()` when `Orchestra\Testbench\Dusk\Options::$providesApplicationServer` set to `false`.

## 8.19.1

Released: 2024-01-03

### Changes

* Update skeleton to match v10.3.1.

## 8.19.0

Released: 2023-12-28

### Changes

* Update minimum support for Testbench v8.19.0+. ([v8.18.0...v8.19.0](https://github.com/orchestral/testbench/compare/v8.18.0...v8.19.0))
* Utilise `Illuminate\Filesystem\join_paths()` function.

## 8.18.0

Released: 2023-12-19

### Changes

* Update minimum support for Testbench v8.18.0+. ([v8.17.0...v8.18.0](https://github.com/orchestral/testbench/compare/v8.17.0...v8.18.0))

## 8.17.0

Released: 2023-12-06

### Changes

* Update minimum support for Testbench v8.17.0+. ([v8.16.0...v8.17.0](https://github.com/orchestral/testbench/compare/v8.16.0...v8.17.0))
* Update minimum support for Laravel Dusk v7.12.0+. ([v7.11.3...v7.12.0](https://github.com/laravel/dusk/compare/v7.11.3...v7.12.0))

## 8.16.1

Released: 2023-12-06

### Changes

* Update skeleton to match v10.2.10.

## 8.16.0

Released: 2023-12-04

### Added

* Added the following attributes:
  - `Orchestra\Testbench\Dusk\Attributes\BeforeServing`
  - `Orchestra\Testbench\Dusk\Attributes\RestartServer`
* Backport `startServing()` and `reloadServing()` to `Orchestra\Testbench\Dusk\CanServeSite` trait.
* Add `createServingApplicationForDuskServer` method to `Orchestra\Testbench\Dusk\CanServeSite` trait.
* Added new PHPUnit Attribute to run the default `laravel`, `cache`, `notifications`, `queue` and `session` database migrations using `Orchestra\Testbench\Attributes\WithMigration`.

### Changes

* Update minimum support for Testbench v8.16.0+. ([v8.15.0...v8.16.0](https://github.com/orchestral/testbench/compare/v8.15.0...v8.16.0))
* Allow passing method name to `Orchestra\Testbench\Dusk\CanServeSite::beforeServingApplication()` method.
* Add `#[Override]` attribute to relevant methods, this require `symfony/polyfill-php83` as backward compatibility for PHP 8.1 and 8.2.

### Deprecated

* Deprecate `getFreshApplicationToServe` method on `Orchestra\Testbench\Dusk\CanServeSite` trait, use `createServingApplicationForDuskServer` instead.

## 8.15.0

Released: 2023-11-10

### Changes

* Update minimum support for Testbench v8.15.0+. ([v8.14.0...v8.15.0](https://github.com/orchestral/testbench/compare/v8.14.0...v8.15.0))
* Refactor `Orchetra\Testbench\Dusk\DuskServer`.

## 8.14.2

Released: 2023-11-02

### Changes

* Update skeleton to match v10.2.8.

## 8.14.1

Released: 2023-11-02

### Changes

* Update skeleton to match v10.2.7.

## 8.14.0

Released: 2023-10-09

### Changes

* Update minimum support for Testbench v8.14.0+. ([v8.13.0...v8.14.0](https://github.com/orchestral/testbench/compare/v8.13.0...v8.14.0))
* Update minimum support for Laravel Dusk v7.11.3+. ([v7.11.1...v7.11.3](https://github.com/laravel/dusk/compare/v7.11.1...v7.11.3))

## 8.13.0

Released: 2023-10-09

### Changes

* Update minimum support for Testbench v8.13.0+. ([v8.12.0...v8.13.0](https://github.com/orchestral/testbench/compare/v8.12.0...v8.13.0))
* Update minimum support for Laravel Dusk v7.11.1+. ([v7.11.0...v7.11.1](https://github.com/laravel/dusk/compare/v7.11.0...v7.11.1))

## 8.12.2

Released: 2023-09-30

### Fixes

* Fixes forwarding environment variables using `Env::forward()`.

## 8.12.1

Released: 2023-09-27

### Changes

* Code refactors.

## 8.12.0

Released: 2023-09-26

### Changes

* Update minimum support for Testbench v8.12.0+. ([v8.11.0...v8.12.0](https://github.com/orchestral/testbench/compare/v8.11.0...v8.12.0))
* Improves integration with `Orchestra\Testbench\Concerns\WithWorkbench` trait.
* Use `Orchestra\Testbench\Foundation\Env::forward()` to handle sending environment variables via Symfony Process.

## 8.11.0

Released: 2023-08-29

### Changes

* Update minimum support for Testbench v8.11.0+. ([v8.10.0...v8.11.0](https://github.com/orchestral/testbench/compare/v8.10.0...v8.11.0))
* Update minimum support for Laravel Dusk v7.11.0+. ([v7.9.0...v7.11.0](https://github.com/laravel/dusk/compare/v7.9.0...v7.11.0))

## 8.10.0

Released: 2023-08-29

### Changes

* Update minimum support for Testbench v8.10.0+. ([v8.9.1...v8.10.0](https://github.com/orchestral/testbench/compare/v8.9.1...v8.10.0))

## 8.9.2

Released: 2023-08-23

### Fixes

* Fixes usage with `Orchestra\Testbench\Concerns\WithWorkbench`.

## 8.9.1

Released: 2023-08-22

### Added

* Added `Orchestra\Testbench\Dusk\Concerns\InteractsWithWebDriverOptions`.

### Changes

* Update minimum support for Testbench v8.9.1+. ([v8.9.0...v8.9.1](https://github.com/orchestral/testbench/compare/v8.9.0...v8.9.1))
* Utilise `setUpTheTestEnvironmentTraitToBeIgnored()` method.

## 8.9.0

Released: 2023-08-19

### Changes

* Update minimum support for Testbench v8.9.0+. ([v8.8.0...v8.9.0](https://github.com/orchestral/testbench/compare/v8.8.0...v8.9.0))

## 8.8.0

Released: 2023-08-15

### Changes

* Update minimum support for Testbench v8.8.0+. ([v8.6.3...v8.8.0](https://github.com/orchestral/testbench/compare/v8.6.3...v8.8.0))
* Update `laravel/bootstrap/app.php` to match `orchestra/testbench-core`.

## 8.7.2

Released: 2023-08-10

### Changes

* Update minimum support for Testbench v8.6.3+. ([v8.6.2...v8.6.3](https://github.com/orchestral/testbench/compare/v8.6.2...v8.6.3))

## 8.7.1

Released: 2023-08-10

### Changes

* Update minimum support for Testbench v8.6.2+. ([v8.6.0...v8.6.2](https://github.com/orchestral/testbench/compare/v8.6.0...v8.6.2))

## 8.7.0

Released: 2023-08-08

### Changes

* Update minimum support for Testbench v8.6.0+. ([v8.5.7...v8.6.0](https://github.com/orchestral/testbench/compare/v8.5.7...v8.6.0))
* Update minimum support for Laravel Dusk v7.9.0+. ([v7.8.0...v7.9.0](https://github.com/laravel/dusk/compare/v7.8.0...v7.9.0))
* Autoload `Laravel\Dusk\DuskServiceProvider` service provider.

## 8.6.7

Released: 2023-07-25

### Fixes

* Fixes running `DuskServer` on certain environment where PHP executable path need to be wrapped using quote.

## 8.6.6

Released: 2023-07-22

### Changes

* Update `orchestra/dusk-updater` to support ChromeDriver `115`+.

## 8.6.5

Released: 2023-07-12

### Changes

* Update minimum support for Laravel Dusk v7.8.0+. ([v7.7.1...v7.8.0](https://github.com/laravel/dusk/compare/v7.7.1...v7.8.0))
* Update skeleton to match v10.2.5.

## 8.6.4

Released: 2023-06-13

### Changes

* Update minimum support for Testbench v8.5.7+. ([v8.5.0...v8.5.7](https://github.com/orchestral/testbench/compare/v8.5.0...v8.5.7))

## 8.6.3

Released: 2023-05-26

### Changes

* Update skeleton to match v10.2.2.

## 8.6.2

Released: 2023-05-17

### Changes

* Update skeleton to match v10.2.1.

## 8.6.1

Released: 2023-05-09

### Changes

* Update skeleton to match v10.2.0.
* Update minimum support for Laravel Dusk v7.7.1+. ([v7.7.0...v7.7.1](https://github.com/laravel/dusk/compare/v7.7.0...v7.7.1))

## 8.6.0

Released: 2023-04-18

### Changes

* Update minimum support for Testbench v8.5.0+. ([v8.4.0...v8.5.0](https://github.com/orchestral/testbench/compare/v8.4.0...v8.5.0))

## 8.5.0

Released: 2023-04-14

### Changes

* Update minimum support for Testbench v8.4.0+. ([v8.3.0...v8.4.0](https://github.com/orchestral/testbench/compare/v8.3.0...v8.4.0))
* Supports PHPUnit 10.1.

## 8.4.1

Released: 2023-04-12

### Changes

* Update skeleton to match v10.0.6.

## 8.4.0

Released: 2023-04-05

### Changes

* Update minimum support for Testbench v8.3.0+. ([v8.2.1...v8.3.0](https://github.com/orchestral/testbench/compare/v8.2.1...v8.3.0))
* Add `setUpTheTestEnvironmentTraitToBeIgnored()` method to determine `setup<Concern>` and `teardown<Concern>` with imported traits that should be used on a given trait.

## 8.3.1

Released: 2023-04-03

### Changes

* Update minimum support for Testbench v8.2.1+. ([v8.2.0...v8.2.1](https://github.com/orchestral/testbench/compare/v8.2.0...v8.2.1))

## 8.3.0

Released: 2023-04-01

### Changes

* Update minimum support for Testbench v8.2.0+. ([v8.1.0...v8.2.0](https://github.com/orchestral/testbench/compare/v8.1.0...v8.2.0))

## 8.2.0

Released: 2023-03-27

### Changes

* Update minimum support for Testbench v8.1.0+. ([v8.0.8...v8.1.0](https://github.com/orchestral/testbench/compare/v8.0.8...v8.1.0))

## 8.1.3

Released: 2023-03-10

### Changes

* Update minimum support for Testbench v8.0.8+. ([v8.0.7...v8.0.8](https://github.com/orchestral/testbench/compare/v8.0.7...v8.0.8))

## 8.1.2

Released: 2023-03-09

### Changes

* Update minimum support for Testbench v8.0.7+. ([v8.0.3...v8.0.7](https://github.com/orchestral/testbench/compare/v8.0.3...v8.0.7))


## 8.1.1

Released: 2023-03-03

### Changes

* Allow using environment variable `DUSK_HEADLESS_MODE` value (when available).

## 8.1.0

Released: 2023-03-02

### Added

* Allow using `--headless=new` available from Chrome v109.

### Changes

* Update minimum support for Laravel Dusk v7.7.0+. ([v7.6.0...v7.7.0](https://github.com/laravel/dusk/compare/v7.6.0...v7.7.0))

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
