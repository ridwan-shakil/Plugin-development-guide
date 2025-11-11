# WP Coding Standards — Global + Per‑Project + Usage

This document contains **three note-files** you can save in your GitHub repo for quick reference.

* **1_global-setup.md** — Global installation & VS Code integration (one-time setup for your machine).
* **2_project-setup.md** — Per-project (local) composer setup and VS Code workspace settings.
* **3_how-to-use-and-get-approved.md** — How to run checks, fix common issues, and a pre-submission checklist to maximize chances of *first-time acceptance*.

---

# 1) `1_global-setup.md`

```
# Global setup (one-time per machine)

Purpose: install PHPCS + standards globally so any project and your VS Code editor can reuse them.

Supported OS: Windows, macOS, Linux

## 1. Verify prerequisites
- PHP >= 7.4 (recommended current dev PHP version like 8.x)
- Composer installed and in PATH
- Git and VS Code

Commands to check:
```

php -v
composer -V
git --version

````

## 2. Install packages globally via Composer
Open PowerShell (Windows) or Terminal (macOS / Linux):

```bash
composer global require \
  squizlabs/php_codesniffer:^3.13 \
  wp-coding-standards/wpcs:^3.0 \
  phpcompatibility/php-compatibility:^9.3 \
  phpcsstandards/phpcsutils:^3.0 \
  phpcsstandards/phpcsextra:^1.0
````

Notes:

* Versions above are examples — composer will pick compatible versions. Pin if needed.
* `phpcsutils` and `phpcsextra` are needed for modern WPCS releases.

## 3. Find Composer global home

```bash
composer global config home
```

Typical outputs:

* Windows: `C:\Users\<User>\AppData\Roaming\Composer`
* macOS/Linux: `~/.composer` or `~/.config/composer`

## 4. Register installed standards with PHPCS

Use full absolute paths (Windows) or tilde path (macOS/Linux).

### Windows (PowerShell / CMD)

```powershell
phpcs --config-set installed_paths "C:\Users\<User>\AppData\Roaming\Composer\vendor\wp-coding-standards\wpcs,C:\Users\<User>\AppData\Roaming\Composer\vendor\phpcompatibility\php-compatibility,C:\Users\<User>\AppData\Roaming\Composer\vendor\phpcsstandards\phpcsutils,C:\Users\<User>\AppData\Roaming\Composer\vendor\phpcsstandards\phpcsextra"
```

### macOS / Linux

```bash
phpcs --config-set installed_paths ~/.composer/vendor/wp-coding-standards/wpcs,~/.composer/vendor/phpcompatibility/php-compatibility,~/.composer/vendor/phpcsstandards/phpcsutils,~/.composer/vendor/phpcsstandards/phpcsextra
```

## 5. Verify installed standards

```bash
phpcs -i
```

Expected: `WordPress, WordPress-Core, WordPress-Docs, WordPress-Extra, PHPCompatibility, ...`

## 6. Set default standard (optional)

```bash
phpcs --config-set default_standard WordPress-Extra,PHPCompatibility
```

Now running `phpcs` with no arguments uses those standards by default.

## 7. Locate PHPCS executable for VS Code

### Windows example

`C:\Users\<User>\AppData\Roaming\Composer\vendor\bin\phpcs.bat`

### macOS/Linux example

`~/.composer/vendor/bin/phpcs`

## 8. VS Code: required extensions & settings

Install these extensions:

* **PHP Sniffer** (or `phpcs` extension by Ioannis Kappas / others)
* **Intelephense** (PHP language server)
* **PHP CS Fixer** or **PHPCBF** (optional)

Add to your global VS Code `settings.json` (File → Preferences → Settings → Open Settings (JSON)):

```json
{
  "phpcs.executablePath": "C:\\Users\\<User>\\AppData\\Roaming\\Composer\\vendor\\bin\\phpcs.bat",
  "phpcs.standard": "WordPress-Extra,PHPCompatibility",
  "phpcs.showSources": true,
  "phpcs.ignorePatterns": ["**/vendor/**","**/node_modules/**"],
  "editor.formatOnSave": true
}
```

Adjust the path for macOS/Linux accordingly.

## 9. Windows-specific gotchas

* If `phpcs -i` doesn't show WordPress, re-run `installed_paths` with absolute paths.
* If you see `Referenced sniff "X" does not exist`, make sure `phpcsutils` and `phpcsextra` are installed and re-run `installed_paths`.

## 10. Use PHPCBF to auto-fix simple issues

```bash
phpcbf --standard=WordPress-Extra,PHPCompatibility path/to/your-plugin/
```

---

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

# 3) `3_how-to-use-and-get-approved.md`

```

# How to use the tools, interpret issues, and get accepted on first try

This file explains the typical workflow: detect → auto-fix → manual-fix → security review → final checks.

## 1. Workflow (fast checklist)

* Run `phpcs` (or `composer phpcs`) and read output.
* Run `phpcbf` (or `composer phpcbf`) to auto-fix many style issues.
* Manually fix remaining warnings & errors (security & logic issues require human work).
* Run `phpcs` again until green or only acceptable exceptions remain.
* Ensure no PHP warnings/notices with `WP_DEBUG` enabled.
* Verify plugin activation, admin pages, and frontend behavior.
* Prepare plugin zip/commit with correct headers and assets.

## 2. Common PHPCS messages & how to fix them

### A. `WordPress.Security.EscapeOutput.OutputNotEscaped`

**Cause:** Output printed without escaping.
**Fix:** Escape using the appropriate function depending on context.

Examples:

* HTML attribute: `echo esc_attr( $value );`
* HTML text: `echo esc_html( $value );`
* Inside rich HTML (allowed tags): `echo wp_kses_post( $html );`

**Before**:

```php
echo $user_name;
```

**After**:

```php
echo esc_html( $user_name );
```

---

### B. `WordPress.Security.NonceVerification` or Missing nonce

**Cause:** Action or form submission not protected by nonce verification.
**Fix:** Add `wp_nonce_field()` to the form and `check_admin_referer()` in handler.

**Form**:

```php
wp_nonce_field( 'my_action', 'my_nonce' );
```

**Handler**:

```php
if ( ! isset( $_POST['my_nonce'] ) || ! check_admin_referer( 'my_action', 'my_nonce' ) ) {
    wp_die( 'Security check failed' );
}
```

---

### C. `WordPress.Security.ValidatedSanitizedInput.InputNotSanitized` or `InputNotValidated`

**Cause:** Using `$_POST`/`$_GET` values directly.
**Fix:** Validate and sanitize input.

Examples:

```php
$qty = isset( $_POST['qty'] ) ? intval( $_POST['qty'] ) : 0;
$name = isset( $_POST['name'] ) ? sanitize_text_field( wp_unslash( $_POST['name'] ) ) : '';
```

---

### D. `WordPress.DB.PreparedSQL.InterpolatedNotPrepared` (SQL issues)

**Cause:** Building SQL with variable interpolation.
**Fix:** Use `$wpdb->prepare()`.

```php
global $wpdb;
$sql = $wpdb->prepare( "SELECT * FROM $wpdb->posts WHERE post_status = %s", 'publish' );
$rows = $wpdb->get_results( $sql );
```

---

### E. `WordPress.NamingConventions.PrefixAllGlobals`

**Cause:** Global functions/variables/classes not prefixed.
**Fix:** Prefix everything with your plugin slug (e.g. `rs_myplugin_` or `RS_MyPlugin_`). Use namespaces for classes where appropriate.

---

## 3. Steps to resolve an issue reported by PHPCS

1. Read the rule name and message (e.g. `WordPress.Security.EscapeOutput.OutputNotEscaped`).
2. Search the rule online (WPCS docs) or inspect the code & context.
3. If it's a formatting issue, run `phpcbf`.
4. For security issues (escape, sanitize, nonce), apply the appropriate security function and re-run PHPCS.
5. If you intentionally need to bypass a rule, add a narrowly scoped `// phpcs:ignore` comment with explanation — use sparingly.

Example of narrow ignore:

```php
// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- value is safe because it is internal and escaped earlier.
echo $already_escaped_html;
```

## 4. Security checklist (absolutely required before submission)

* No use of `eval()` or `base64_decode()`-obfuscated PHP.
* All user input validated and sanitized.
* All output escaped correctly for its context.
* Nonces used for any action that changes state.
* Capability checks (`current_user_can()`) for admin actions.
* Use prepared statements for DB queries.
* No file uploads without proper sanitization and checks.
* No direct file access without `defined( 'WPINC' )` or `ABSPATH` guard.
* No inclusion of premium license keys or external tracking code.

## 5. WordPress.org reviewer checklist (quick)

* Plugin header in main file (Plugin Name, Description, Version, Author, Text Domain).
* `readme.txt` present and formatted using the WordPress readme standard.
* Stable tag and correct version in readme and header.
* No PHP warnings or notices when `WP_DEBUG` is true.
* All strings translatable using `__()` / `_e()` and correct textdomain.
* No `eval()` or remote code execution.
* Proper sanitization/escaping/nonces as above.

## 6. Additional Envato notes

* Ensure PHPCompatibility checks pass for the PHP versions you claim to support.
* Include license files for any third‑party libraries.
* No encrypted/obfuscated code.

## 7. Steps to increase first-time acceptance chances

1. Run full PHPCS and PHPCBF: `composer phpcs && composer phpcbf` (or vendor/bin/*).
2. Manually fix remaining security warnings — do not rely on autofix for these.
3. Test plugin with `define( 'WP_DEBUG', true ); define( 'WP_DEBUG_LOG', true );` and confirm no warnings.
4. Test on a clean WP install (classic and block editor if you add blocks) and activation/deactivation.
5. Make sure readme.txt, screenshots, and plugin headers are correct.
6. Ensure packaging: follow WordPress.org SVN structure when preparing tag release or zip.

## 8. Useful commands summary

* `vendor/bin/phpcs` — run checks
* `vendor/bin/phpcbf` — auto-fix fixable problems
* `composer phpcs` / `composer phpcbf` if scripts were added
* `php -l file.php` — quick PHP syntax check

## 9. Example pre-release checklist (copy to your repo)

* [ ] `composer phpcs` — passes or only acceptable exceptions
* [ ] `composer phpcbf` — run and commit changes
* [ ] No `PHP` warnings with `WP_DEBUG` on
* [ ] All strings are translatable
* [ ] readme.txt filled and formatted
* [ ] License files included
* [ ] Tested on a clean WP install
* [ ] Verified required WordPress hooks and filters are used properly

## 10. When you still get rejected — what reviewers usually ask for

* Missing escaping/sanitization — add correct functions and explain in reply.
* Function/class name collisions — ensure unique prefixes/namespaces.
* External remote requests without reason — document or remove.
* Premium functionality hidden in free plugin — avoid.

---

# Appendix: Example `phpcs.xml` (copy into project root)

```xml
<?xml version="1.0"?>
<ruleset name="Plugin Standards">
  <description>WordPress.org + Envato ready rules</description>
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

---

Save each of these three files in your repo as `docs/1_global-setup.md`, `docs/2_project-setup.md`, and `docs/3_how-to-use-and-get-approved.md` so they are easy to find later.

Good luck — and when you want, I can convert these files into a polished `README.md` or into separate Markdown files committed to a GitHub repo (I can output the full file contents in a single reply so you can copy-paste).```
