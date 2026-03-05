# ✅ WordPress Plugin Review — One-Page Checklist

## Plugin Identity
☐ Plugin name is unique
☐ Plugin slug is unique and lowercase-hyphen format
☐ Plugin folder name = plugin slug
☐ Text domain = plugin slug
☐ Plugin header fields complete (Version, Requires PHP, Tested up to, etc.)
☐ Plugin does not use trademarked or misleading names

Prefixing & Collision Safety

☐ PHP namespace used
☐ All functions/classes/constants prefixed
☐ Option keys prefixed
☐ Transients prefixed
☐ Database tables prefixed
☐ Cron events prefixed
☐ AJAX actions prefixed
☐ REST routes prefixed
☐ Script/style handles prefixed
☐ CPTs & taxonomies prefixed
☐ Shortcodes prefixed

Security

☐ Capability checks added for admin actions
☐ Nonces used for forms, AJAX, and updates
☐ All input sanitized (sanitize_*)
☐ Input validated when needed
☐ All output escaped (esc_html, esc_attr, esc_url, etc.)
☐ SQL queries use $wpdb->prepare()
☐ All PHP files block direct access (ABSPATH check)

Coding Standards

☐ WordPress Coding Standards followed
☐ PHPCS/WPCS errors fixed
☐ No deprecated functions used
☐ No warnings or notices with WP_DEBUG enabled
☐ No debug code (var_dump, print_r, etc.)

Architecture & Performance

☐ No procedural logic outside bootstrap file
☐ Code organized into classes/modules
☐ Admin and frontend logic separated
☐ Assets enqueued properly (no inline CSS/JS)
☐ Scripts/styles loaded conditionally
☐ No unnecessary global hooks or heavy queries

Internationalization

☐ All user-facing text wrapped in translation functions
☐ Text domain used correctly
☐ .pot file generated (wp i18n make-pot)

Data Handling

☐ Options and transients use prefix
☐ User data handled safely
☐ uninstall.php removes plugin data properly (if appropriate)
☐ Plugin does not delete user data without consent

External Services

☐ No hidden tracking or telemetry
☐ No unnecessary external API calls
☐ Any external service clearly documented

Testing

☐ Plugin activates without errors
☐ Plugin deactivates cleanly
☐ Plugin deletes without fatal errors
☐ Tested with latest WordPress version
☐ Tested with supported PHP versions

readme.txt

☐ readme.txt follows WordPress format
☐ Required fields filled (Requires WP, PHP, Tags, License, etc.)
☐ Description, Installation, FAQ, and Changelog included

Plugin Assets

☐ Icon created (128×128 / 256×256)
☐ Banner created (772×250 / 1544×500)
☐ Screenshots added if needed

Final Check

☐ Plugin contains no obfuscated or encoded code
☐ All third-party libraries are GPL-compatible
☐ No admin spam, ads, or forced promotions
☐ Plugin works independently without breaking other plugins
