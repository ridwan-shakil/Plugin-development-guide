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

