# Simple setup if pc already has : php, mysql, composer, phpunit, wp-cli, git
### 1) Open "local wp" > start server > open site shell > Run below commands : 
        1)  wp scaffold plugin {plugin-slug}
        2)  cd wp-content/plugins/{plugin-slug}
        3)  bin/install-wp-tests.sh wp_tests root root localhost 
        4) composer require --dev phpunit/phpunit
        5) composer require --dev yoast/phpunit-polyfills


# 2) Change the Temp directory
          1) Win + R > cmd > echo %TEMP%  > copy the result path 
          2) wordpress-tests-lib/wp-tests-config.php in your Temp directory and edit the constant ABSPATH on line 4 and prepend your %TEMP% directory.

### Documentation : https://dev.to/eliehanna/how-to-run-phpunit-in-a-wordpress-plugin-on-windows-using-localwp-1414





----------------------- 
# pc needs: php, mysql, composer, phpunit, wp-cli, git

## win> system environment > 
        path > add php path , sql path , wp-cli 
        TMP & temp > may nedd to adjust path
## How to do unit testing of a WordPress plugin — Step by step 

### Prerequisites
        * PHP (version compatible with your PHPUnit version). | wp unit test does not supports latest php unit . 
        * Composer.
        * MySQL (or MariaDB) for the test DB.
        * WP-CLI (optional but helpful) and `wp` command for scaffolding. If you dont have it, you can still set up tests manually.


## Step 1 — Add PHPUnit to dev dependencies

```bash
    composer require --dev phpunit/phpunit:"^9.6"     ## always use latest supported version, not latest phpunit 
OR 
    composer require --dev phpunit/phpunit:^9.6 --with-all-dependencies     ##downgrade/upgrade whatever else is necessary to make it compatible.

```

## reset everything if goes wrong 
    del composer.lock
    rmdir vendor -Recurse -Force
    
> Tip: check the PHPUnit major version compatibility with your PHP version (e.g., PHPUnit 9 for PHP 7.3+ / 8.x / 8.1+ depending on releases).

---

## Step 2 — Scaffold test boilerplate (easy way with WP-CLI)

```bash
wp scaffold plugin-tests my-plugin-slug
```

### This creates:
        * `tests/` folder with sample tests.
        * `phpunit.xml.dist` (PHPUnit config).
        * `bin/install-wp-tests.sh` script (sets up a test WP install & test DB).

If you can’t use WP-CLI, you can manually copy the WP test suite bootstrap and create `phpunit.xml.dist` following the WordPress handbook.

---

## Step 3 — Install the WP test suite and create test DB

Run the installer script (edit DB creds accordingly):

```bash
    
composer require --dev wp-phpunit/wp-phpunit:^6.8 --with-all-dependencies
mysql -u root -e "SHOW DATABASES;"`
    OR (old)
bash bin/install-wp-tests.sh wordpress_test root '' localhost latest
```
        * `wordpress_test` = test database name
        * `root` = DB user (change to your user)
        * `''` = DB password (change as needed)
        * `latest` = WordPress version to download for tests

This downloads WP test files and creates `wp-tests-config.php` used by the test bootstrap.

---

## Step 4 — Write your first WordPress-aware test

Example: test that `update_option` and `get_option` work with your plugin logic.

```php
// tests/test-options.php
class OptionsTest extends WP_UnitTestCase {
    public function test_update_and_get_option() {
        // Arrange / Act
        update_option('myplugin_setting', 'hello');

        // Assert
        $this->assertEquals('hello', get_option('myplugin_setting'));
    }
}
```

### Key notes:
        * Tests live under `tests/`.
        * Test classes extend `WP_UnitTestCase`.
        * Use `self::factory()` (or `$this->factory`) to create fixtures (posts, users, terms).

**Example using factory**

```php
public function test_create_post_with_factory() {
    $post_id = self::factory()->post->create([
        'post_title' => 'Test post',
        'post_status' => 'publish',
    ]);

    $this->assertIsInt($post_id);
    $post = get_post($post_id);
    $this->assertEquals('Test post', $post->post_title);
}
```

---

## Step 5 — Run tests

```bash
# run all tests
vendor/bin/phpunit

# run a single file or method
vendor/bin/phpunit --filter test_update_and_get_option
```

Common PHPUnit flags: `--filter` (run specific test), `-v` (verbose), `--stop-on-failure`.

---

## Step 6 — Best practices & tips
        * **Arrange → Act → Assert (AAA)** for every test.
        * **Small, deterministic tests**: avoid random data or external network calls.
        * **Mock external services** (HTTP, APIs) so tests remain fast.
        * **Reset global state** between tests — `WP_UnitTestCase` helps here.
        * **Name tests clearly**: `test_methodName_condition_expectedResult()` or descriptive phrases.
        * Use data providers for multiple input combinations.
        * Keep most tests fast; if a test really needs a full environment, mark it as integration/functional.
        * Use CI (GitHub Actions / GitLab CI) to run tests on push/PR.


## Quick debug checklist when a test fails
                * Run the failing test alone with `--filter`.
                * Add `var_export()` / `error_log()` or use `--debug` for more info.
                * Ensure the test DB credentials and `wp-tests-config.php` are correct.
                * Check if your plugin bootstrap is correctly loaded by the test bootstrap.


## Quick cheat-sheet (commands)
        * `composer require --dev phpunit/phpunit`
        * `wp scaffold plugin-tests my-plugin-slug`
        * `bash bin/install-wp-tests.sh wordpress_test dbuser dbpass dbhost latest`
        * `vendor/bin/phpunit`

## Final tiny checklist for saving to GitHub
        * Add `tests/` and `phpunit.xml.dist` to repo.
        * Add a short `TESTING.md` with the install command and any DB creds guidance (don't commit real passwords).
        * Optionally add a GitHub Actions workflow file to run `composer install --no-interaction --prefer-dist` and `vendor/bin/phpunit` on push/PR.

---

**Quick mnemonic to remember**: *AAA + FACTORIES = reliable WP tests*
(Arrange, Act, Assert — and use `self::factory()` for WP fixtures)


