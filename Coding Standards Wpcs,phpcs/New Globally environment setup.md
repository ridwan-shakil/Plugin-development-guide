📄 1_global-setup.md
________________________________________
# 🧭 Global Setup — PHPCS + WPCS + PHPCompatibility

> **Purpose:**  
> Configure global PHP_CodeSniffer (PHPCS) with WordPress Coding Standards (WPCS) and PHPCompatibility.  
> Ideal for WordPress plugin/theme developers who want one global setup across all projects.

---

## ⚙️ 0. Prerequisites

Make sure the following are installed:

| Tool | Required | Check Command |
|------|-----------|----------------|
| PHP 7.4+ | ✅ | `php -v` |
| Composer | ✅ | `composer -V` |
| Git | Optional | `git --version` |
| VS Code | Optional | — |

---

## 📦 1. Install All Required Packages Globally

Run this once from **PowerShell (Windows)** or **Terminal (macOS/Linux):**

```bash
composer global require \
  squizlabs/php_codesniffer:"*" \
  wp-coding-standards/wpcs:"*" \
  phpcompatibility/php-compatibility:"*" \
  phpcompatibility/phpcompatibility-wp:"*" \
  phpcompatibility/phpcompatibility-paragonie:"*" \
  phpcsstandards/phpcsextra:"*" \
  phpcsstandards/phpcsutils:"*"
```

# This installs globally:
•	✅ PHP_CodeSniffer (phpcs, phpcbf)
•	✅ WordPress Coding Standards (wpcs)
•	✅ PHPCompatibility + PHPCompatibilityWP
•	✅ Paragonie Sniffs
•	✅ PHPCSExtra + PHPCSUtils
💡 Using :* allows Composer to pick the latest compatible versions automatically.
________________________________________

#📁 2. Register Standards with PHPCS
Set the global installed paths for all coding standards.
🪟 Windows Example
```php
phpcs --config-set installed_paths `
  "C:\Users\<YourUser>\AppData\Roaming\Composer\vendor\wp-coding-standards\wpcs,\
C:\Users\<YourUser>\AppData\Roaming\Composer\vendor\phpcompatibility\php-compatibility,\
C:\Users\<YourUser>\AppData\Roaming\Composer\vendor\phpcompatibility\phpcompatibility-paragonie,\
C:\Users\<YourUser>\AppData\Roaming\Composer\vendor\phpcompatibility\phpcompatibility-wp,\
C:\Users\<YourUser>\AppData\Roaming\Composer\vendor\phpcsstandards\phpcsextra,\
C:\Users\<YourUser>\AppData\Roaming\Composer\vendor\phpcsstandards\phpcsutils"
```
#🍎 macOS / Linux Example
```php
phpcs --config-set installed_paths \
  ~/.composer/vendor/wp-coding-standards/wpcs,\
  ~/.composer/vendor/phpcompatibility/php-compatibility,\
  ~/.composer/vendor/phpcompatibility/phpcompatibility-paragonie,\
  ~/.composer/vendor/phpcompatibility/phpcompatibility-wp,\
  ~/.composer/vendor/phpcsstandards/phpcsextra,\
  ~/.composer/vendor/phpcsstandards/phpcsutils
```
________________________________________

#🧩 3. Set Default Standard
Make PHPCS use WordPress + PHPCompatibility by default:
```php
phpcs --config-set default_standard WordPress-Extra,PHPCompatibilityWP
```
Check configuration:
```php
phpcs --config-show
```
Expected output includes:

** default_standard: WordPress-Extra,PHPCompatibilityWP
________________________________________

#🪟 4. Add Composer Global Bin to PATH (Windows)
So you can run phpcs and phpcbf from anywhere.
1.	Start Menu → “Edit the system environment variables”
2.	Click Environment Variables
3.	Under User Variables → Path → Edit → New
4.	Add this line:
5.	C:\Users\<YourUser>\AppData\Roaming\Composer\vendor\bin
6.	Save and restart your terminal.

✅ Verify:
```php
phpcs --version
phpcbf --version
```
💡 On macOS/Linux, add this line to your shell config:
export PATH="$HOME/.composer/vendor/bin:$PATH"
________________________________________

#🔍 5. Verify the Installation
Run these to confirm everything works:
```php
phpcs --version
phpcs -i
phpcs --config-show
```
✅ Expected in phpcs -i:
•	WordPress, WordPress-Core, WordPress-Docs, WordPress-Extra
•	PHPCompatibility, PHPCompatibilityWP
•	PHPCompatibilityParagonieRandomCompat, PHPCompatibilityParagonieSodiumCompat
•	PHPCSUtils, PHPCSExtra
________________________________________

#💻 6. VS Code Setup (PHPSAB Extension)
If using the PHPSAB extension (valeryanm.vscode-phpsab), add this to your VS Code settings.json:

```bash
  "php.validate.enable": true,
  "[php]": {
    "editor.defaultFormatter": "valeryanm.vscode-phpsab"
  },

  "phpsab.executablePathCS": "C:\\Users\\<YourUser>\\AppData\\Roaming\\Composer\\vendor\\bin\\phpcs.bat",
  "phpsab.executablePathCBF": "C:\\Users\\<YourUser>\\AppData\\Roaming\\Composer\\vendor\\bin\\phpcbf.bat",
  "phpsab.standard": "WordPress-Extra,PHPCompatibilityWP",
  "phpsab.autoRulesets": false,
  "phpsab.sniffOnSave": true,
  "phpsab.fixerEnable": true,
  "phpsab.fixerOnSave": false

```
Tips:
•	executablePathCBF enables auto-fixing (formatter).
•	autoRulesets: false avoids “phpcs.xml not found” errors.
•	Set fixerOnSave: true only after confirming it works properly.
________________________________________

## 🧰 7. Common Commands
Command	Description
phpcs -s .	Scan current folder with default standard
phpcbf -s .	Auto-fix code style issues
phpcs --standard=WordPress-Extra,PHPCompatibilityWP -s .	Run specific standards
php -l file.php	Quick syntax check
________________________________________

## 🚑 8. Troubleshooting
❌ Referenced sniff "XYZ" does not exist
➡ Run phpcs --config-show and re-check installed_paths.
Make sure folders actually exist in AppData\Roaming\Composer\vendor.
________________________________________

## ❌ option "---colors" not known
➡ Reinstall PHPCS:
composer global remove squizlabs/php_codesniffer
composer global require squizlabs/php_codesniffer:"*"
________________________________________

## ❌ FIXER: Configuration error of the application
➡ Add:
"phpsab.executablePathCBF": "C:\\Users\\<User>\\AppData\\Roaming\\Composer\\vendor\\bin\\phpcbf.bat"
________________________________________

## ❌ Unexpected token 'E' ... not valid JSON
➡ Set:
"phpsab.autoRulesets": false
and open the actual plugin folder as the workspace root.
________________________________________

## 🧪 9. (Optional) Per-Project Local Install
If you want standards installed locally (for CI/CD or team sharing):
```bash
composer require --dev \
  squizlabs/php_codesniffer \
  wp-coding-standards/wpcs \
  phpcompatibility/php-compatibility \
  phpcompatibility/phpcompatibility-wp \
  phpcompatibility/phpcompatibility-paragonie \
  phpcsstandards/phpcsextra \
  phpcsstandards/phpcsutils
````
Then:
```bash
vendor/bin/phpcs --config-set installed_paths \
  vendor/wp-coding-standards/wpcs,\
  vendor/phpcompatibility/php-compatibility,\
  vendor/phpcompatibility/phpcompatibility-paragonie,\
  vendor/phpcompatibility/phpcompatibility-wp,\
  vendor/phpcsstandards/phpcsextra,\
  vendor/phpcsstandards/phpcsutils
```
Run using:
```bash
vendor/bin/phpcs -s .
```
________________________________________

## 🧱 10. (Optional) GitHub Actions CI Example
name: PHPCS
```bash
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
      - name: Install PHPCS + Standards
        run: |
          composer global require \
            squizlabs/php_codesniffer \
            wp-coding-standards/wpcs \
            phpcompatibility/php-compatibility \
            phpcompatibility/phpcompatibility-wp \
            phpcompatibility/phpcompatibility-paragonie \
            phpcsstandards/phpcsextra \
            phpcsstandards/phpcsutils
          phpcs --config-set installed_paths \
            ~/.composer/vendor/wp-coding-standards/wpcs,\
            ~/.composer/vendor/phpcompatibility/php-compatibility,\
            ~/.composer/vendor/phpcompatibility/phpcompatibility-paragonie,\
            ~/.composer/vendor/phpcompatibility/phpcompatibility-wp,\
            ~/.composer/vendor/phpcsstandards/phpcsextra,\
            ~/.composer/vendor/phpcsstandards/phpcsutils
      - name: Run PHPCS
        run: phpcs -s --standard=WordPress-Extra,PHPCompatibilityWP .
```
________________________________________

## ✅ 11. Final Verification Checklist
Task	Command	Expected
Check version	phpcs --version	Shows PHPCS 3.x
List standards	phpcs -i	Includes WordPress + PHPCompatibilityWP
Confirm config	phpcs --config-show	Installed paths + default standard visible
Test run	phpcs -s .	Runs without “missing sniff” errors
Fix test	phpcbf -s .	Works correctly
________________________________________

## 🧠 Notes & Best Practices
•	Always use WordPress-Extra,PHPCompatibilityWP as your main standard for WordPress.org / Envato.
•	Run phpcbf manually before commits to auto-fix style issues.
•	Keep PHPCS updated every few months:
•	composer global update squizlabs/php_codesniffer wp-coding-standards/wpcs
•	If working with a team, include a .vscode/settings.json so everyone shares the same linting rules.
________________________________________

## 🧩 Done!
You now have a global PHPCS + WPCS setup with full compatibility for WordPress.org and Envato plugin/theme development.

---

Would you like me to also rewrite your `3_how-to-use-and-get-approved.md` next — matching this new clean, GitHub note style?


