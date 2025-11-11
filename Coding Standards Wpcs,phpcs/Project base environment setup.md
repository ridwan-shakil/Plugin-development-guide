# 2) `2_project-setup.md`

````
# Per-project (local) setup — recommended for reproducibility

Purpose: install PHPCS and standards locally in the project so CI and other devs have identical versions.

## 1. Create project and init composer (if not present)

```bash
cd path/to/your-plugin
composer init --name="vendor/your-plugin" --require-dev="squizlabs/php_codesniffer:^3.13" --no-interaction
````

## 2. Add dev dependencies to project

```bash
composer require --dev \
  squizlabs/php_codesniffer:^3.13 \
  wp-coding-standards/wpcs:^3.0 \
  phpcompatibility/php-compatibility:^9.3 \
  phpcompatibility/phpcompatibility-wp:^1.0 \
  phpcsstandards/phpcsutils:^3.0 \
  phpcsstandards/phpcsextra:^1.0
```

Notes:

* `phpcompatibility-wp` provides WordPress specific compatibility tests for PHPCompatibility.
* Pin versions if you have an enforced policy in your team.

## 3. Register installed_paths for local phpcs

```bash
vendor/bin/phpcs --config-set installed_paths vendor/wp-coding-standards/wpcs,vendor/phpcompatibility/php-compatibility,vendor/phpcompatibility/phpcompatibility-wp,vendor/phpcsstandards/phpcsutils,vendor/phpcsstandards/phpcsextra
```

Verify:

```bash
vendor/bin/phpcs -i
```

You should see local WordPress and compatibility standards.

## 4. Add `phpcs.xml` to project root (example)

Create `phpcs.xml` (see file 3 for final recommended template or copy below):

```xml
<?xml version="1.0"?>
<ruleset name="My Plugin Standards">
  <description>WordPress.org + Envato-ready rules</description>
  <file>.</file>
  <exclude-pattern>vendor/*</exclude-pattern>
  <exclude-pattern>node_modules/*</exclude-pattern>
  <rule ref="WordPress-Extra" />
  <rule ref="WordPress-Docs" />
  <rule ref="PHPCompatibilityWP" />
  <config name="testVersion" value="7.4-8.3" />
  <exclude name="Generic.Files.LineLength.TooLong" />
</ruleset>
```

## 5. Add Composer scripts (convenience)

Add these to your `composer.json` under `scripts`:

```json
"scripts": {
  "phpcs": "vendor/bin/phpcs",
  "phpcbf": "vendor/bin/phpcbf"
}
```

Then you can run:

```
composer phpcs
composer phpcbf
```

## 6. Add `.vscode/settings.json` to project

Project-level VS Code settings (committed to repo) to ensure Developers & CI use project phpcs:

```json
{
  "phpcs.executablePath": "${workspaceFolder}/vendor/bin/phpcs",
  "phpcs.standard": "WordPress-Extra,PHPCompatibility",
  "phpcs.showSources": true,
  "phpcs.ignorePatterns": ["**/vendor/**", "**/node_modules/**"],
  "editor.formatOnSave": false
}
```

Notes:

* Use `${workspaceFolder}` so others in the team will use the local phpcs.
* Consider disabling `formatOnSave` at project level so fixes are explicit.

## 7. Optional: pre-commit git hook

Create `.git/hooks/pre-commit` (make executable) or use Husky. Example simple hook:

```bash
#!/bin/sh
# Run phpcs on staged PHP files
STAGED=$(git diff --cached --name-only --diff-filter=ACM | grep -E "\.(php|inc)$" )
if [ -n "$STAGED" ]; then
  echo "Running phpcs on staged files..."
  echo "$STAGED" | xargs vendor/bin/phpcs
  if [ $? -ne 0 ]; then
    echo "PHPCS failed. Please fix issues before commit."
    exit 1
  fi
fi
```

## 8. CI integration (.github/workflows/phpcs.yml)

```yaml
name: PHPCS
on: [push, pull_request]
jobs:
  phpcs:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v4
      - name: Setup PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: '8.2'
      - name: Install Composer dependencies
        run: composer install --no-interaction --prefer-dist
      - name: Run PHPCS
        run: vendor/bin/phpcs -q
```

## 9. Developer onboarding note (README)

Add a short section in your project README that says how to run `composer phpcs` and how to fix issues with `composer phpcbf`.

```
