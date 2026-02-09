# PHPUnit & WordPress Plugin Testing — Quick Revision Notes

---

# 1) What is PHPUnit and `WP_UnitTestCase`, and why use them

## What is a *unit test*?

* A **unit test** checks a small part of your code (a function or class method) in isolation.
* Benefits: catches regressions, documents expected behavior, speeds refactors, enables CI checks.

## What is **PHPUnit**?

* PHPUnit is the standard testing framework for PHP.
* It provides a test runner, assertions, test lifecycle methods (`setUp`, `tearDown`), and reporting.
* Typical flow: write test classes that extend `PHPUnit\Framework\TestCase`, run `vendor/bin/phpunit`.

**Tiny example**

```php
// src/Calculator.php
class Calculator {
    public function add($a, $b) { return $a + $b; }
}

// tests/CalculatorTest.php
use PHPUnit\Framework\TestCase;

class CalculatorTest extends TestCase {
    public function testAdd() {
        $calc = new Calculator();
        $this->assertEquals(5, $calc->add(2, 3));
    }
}
```

##  What is `WP_UnitTestCase` and why WordPress needs it 

### * WordPress plugins usually call WordPress core functions (`get_option()`, `wp_insert_post()`, etc.). Plain `TestCase` does **not** boot WordPress.
### * `WP_UnitTestCase` is part of the WordPress test framework. It extends PHPUnit’s `TestCase` and:
      * Boots a lightweight WordPress environment for tests.
      * Resets the database between tests so tests are isolated.
      * Provides factories (`$this->factory->post`, `->user`, `->term`, etc.) to create test fixtures quickly.
      * Loads plugin code via the test bootstrap so WP functions are available.

## **Why use them?**

    * To test plugin logic that depends on WordPress.
    * To make safe refactors (tests fail if you break something).
    * To automate checks (CI) before publishing to GitHub, WordPress.org, or CodeCanyon.

## **Mnemonic**: 
      *PHPUnit = engine; 
      WP_UnitTestCase = adapter that boots WordPress.*

---

