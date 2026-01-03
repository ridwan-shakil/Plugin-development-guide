
## Github action can run auto checks for phpcs/wpcs etc on pull requests
### create an empty action 
### pest this file : wp-quality-checks.yml


```
name: WordPress Plugin Quality Checks

on:
  push:
    branches: [ main, master, develop ]
  pull_request:
    branches: [ main, master, develop ]

jobs:
  quality-checks:
    runs-on: ubuntu-latest

    steps:
      - name: Checkout code
        uses: actions/checkout@v4

      - name: Setup PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: '8.1'
          coverage: none
          tools: composer

      - name: Validate PHP syntax
        run: |
          find . -type f -name "*.php" ! -path "./vendor/*" -print0 | xargs -0 -n1 php -l

      - name: Install PHPCS & WordPress standards
        run: |
          composer global config allow-plugins.dealerdirect/phpcodesniffer-composer-installer true
          composer global require \
            phpcsstandards/php_codesniffer:^3.9 \
            wp-coding-standards/wpcs:^3.1 \
            phpcompatibility/phpcompatibility-wp:^2.1

      - name: Verify PHPCS installation
        run: |
          ~/.composer/vendor/bin/phpcs -i

      - name: Auto-fix PHPCS (safe fixes)
        run: |
          ~/.composer/vendor/bin/phpcbf \
            --standard=WordPress \
            --extensions=php \
            --ignore=vendor,node_modules,.github \
            .

      - name: Run PHPCS (WordPress standards)
        run: |
          ~/.composer/vendor/bin/phpcs -v -p \
            --warning-severity=0 \
            --standard=WordPress,WordPress-Extra,WordPress-Docs \
            --extensions=php \
            --ignore=vendor,node_modules,.github \
            .

      - name: Run PHPCompatibility (WP supported PHP versions)
        run: |
          ~/.composer/vendor/bin/phpcs \
            --standard=PHPCompatibilityWP \
            --runtime-set testVersion 7.4-8.3 \
            --extensions=php \
            --ignore=vendor,node_modules,.github \
            .


```
