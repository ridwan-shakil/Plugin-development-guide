# Running WordPress Plugin Unit Tests via GitHub Actions (CI)

This note explains the **minimal steps** to run WordPress plugin unit tests automatically on every push / PR using **GitHub Actions**.

---

## 1. Why use CI for WP unit tests

- No need to configure WordPress test environment locally
- Tests run in a clean environment every time
- Catches errors early before merging
- Matches real-world, professional workflows

> WordPress “unit tests” are closer to **integration tests**, so CI is ideal.

---

## 2. Prerequisites in the plugin repo

Your plugin should already have:

- A valid plugin main file
- `tests/` directory
- `tests/bootstrap.php`
- At least one test class extending `WP_UnitTestCase`
- `phpunit.xml.dist`

---

## 3. Create `composer.json` (dev-only)

Purpose:
- Install PHPUnit and WP-compatible testing tools
- Lock versions for CI stability

Key points:
- Use `require-dev`
- Pin PHPUnit to a WP-safe version (e.g. 9.x)
- Add a PHP platform version to avoid CI mismatches
- Commit both `composer.json` and `composer.lock`

---

## 4. Install WordPress test installer script

WordPress provides an official script to install:
- WordPress core
- WP test library
- Test database

Steps:
1. Create a `bin/` directory
2. Download `install-wp-tests.sh` from WordPress core repo
3. Make it executable
4. Commit it

This script will be reused by CI.

---

## 5. Create GitHub Actions workflow (`.yml`)

Purpose:
- Define when tests run (push / PR)
- Set up PHP
- Start MySQL
- Install WordPress test suite
- Run PHPUnit

Key ideas (not full config):
- Use `ubuntu-latest`
- Use MySQL service
- Install `svn` (required by WP test installer)
- Cache:
  - `vendor/` (Composer)
  - `/tmp/wordpress` and `/tmp/wordpress-tests-lib`
- Run installer **non-interactively** using `yes |`
- Run PHPUnit via `php vendor/bin/phpunit`

---

## 6. Important CI-specific rules

- Never rely on executable permissions → always run `php vendor/bin/phpunit`
- Avoid `latest` WordPress in CI → pin a version for stability
- Ignore MySQL warnings in logs (they are normal in CI)
- Only care about:
  - Exit code
  - PHPUnit result (`OK`, `FAILURES`)

---

## 7. Test discovery rules (very important)

For PHPUnit to find tests:
- Test files must end with `Test.php`
- Test classes must end with `Test`
- Tests must live inside the directory defined in `phpunit.xml.dist`

Example:
