# WordPress Plugin – CI / Online Unit Testing Setup (Step-by-Step)

## For a new plugin:
    1. Copy .github/workflows/phpunit.yml
    2. Copy composer.json test deps
    3. copy phpunit.xml.dist
    4. extra (create a .gitignore file inside /vendor)

### Run on :
      composer install
### Run on : root location: sitebylocal/app/public  OR ( localwp > site shell ) 
      wp scaffold plugin-tests {your-plugin-slug}

### Run on : Power shell  
      cd wp-content/plugins/{your-Plugin-slug)
      bash bin/install-wp-tests.sh wordpress_test root '' localhost latest


### small fixes
        fix sample-test file name to SampleTest.php 
        fix the (extends \WP_UnitTestCase)

--------------------------
## in Details
This guide assumes you already have:
- `composer.json`
- `phpunit.xml.dist`
- GitHub Actions `.yml` file

This document only covers **what to do next** to scaffold, prepare, and run WordPress unit tests locally and in CI.

---

## 1. Install Composer dependencies

From the plugin root:

```bash
composer install
```

This installs:

PHPUnit

WordPress test dependencies (if defined in composer.json)

2. Scaffold WordPress PHPUnit test environment (automatic)

Use WP-CLI to scaffold the testing structure.

wp scaffold plugin-tests your-plugin-slug


This creates:

tests/ directory

tests/bootstrap.php

tests/test-sample.php

bin/install-wp-tests.sh

Updates phpunit.xml.dist if missing

⚠️ Run this once per plugin.

3. Install WordPress test suite locally

Run the installer script:

bash bin/install-wp-tests.sh wordpress_test root '' localhost latest


This will:

Download WordPress core into /tmp/wordpress

Download test library into /tmp/wordpress-tests-lib

Create a test database

4. Create a test file using correct naming

Inside tests/:

touch tests/test-example.php


File name must start with test-, otherwise PHPUnit will skip it.

Example structure:

class Example_Test extends WP_UnitTestCase {
    public function test_something_works() {
        $this->assertTrue( true );
    }
}

5. Run unit tests locally
vendor/bin/phpunit


If configured correctly, you should see:

WordPress loading

Database created

Tests executed

6. Push code to GitHub
git add .
git commit -m "Add WordPress unit tests"
git push


GitHub Actions will:

Spin up PHP + MySQL

Install WP test suite

Run PHPUnit automatically

7. Debugging tips (important)

If you see “No tests executed”

File name must be test-*.php

Class name must extend WP_UnitTestCase

If CI is slow

Cache /tmp/wordpress and /tmp/wordpress-tests-lib

Cache vendor/
