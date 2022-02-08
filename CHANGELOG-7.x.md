# Change for 7.x

This changelog references the relevant changes (bug and security fixes) done to `orchestra/testbench-dusk`.

## 7.0.0

Released: 2022-02-08

### Changes

* Update support for Laravel Framework v9.
* Increase minimum PHP version to 8.0 and above (tested with 8.0 and 8.1).
* Following internal `Orchestra\Testbench\Dusk\Bootstrap\LoadConfiguration` class has been marked as `final`.
* Moved `resources/lang` skeleton files to `lang` directory.

### Removed

* Removed deprecated `Orchestra\Testbench\Dusk\TestCase::baseUrl()`, use `applicationBaseUrl()` instead.
