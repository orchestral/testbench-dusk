# Change for 5.x

This changelog references the relevant changes (bug and security fixes) done to `orchestra/testbench-dusk`.

## 5.0.0

Released: 2020-03-02

### Changes

* Update Laravel 7 skeleton:
    - Rename default `Redis` alias under `app.aliases` to `RedisManager` to avoid incompatibility when running tests using `phpredis` extension.
    - Add `Http` alias under `app.aliases`.
    - Add `config/cors.php`.
    - Update `database`, `filesystem`, `mail`, `session` and `view` configuration file.
