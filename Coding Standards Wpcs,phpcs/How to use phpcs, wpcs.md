* **3_how-to-use-and-get-approved.md** — How to run checks, fix common issues, and a pre-submission checklist to maximize chances of *first-time acceptance*.

## Prerequsits
1) coding standard setup globally (Main engine)
2) VS code extentions (For realtime error showing & fixing)
3) windown environment veriable path setup (Must do once)
4) 
  
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
