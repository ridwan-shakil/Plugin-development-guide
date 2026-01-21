# WordPress Database Query Notes

Central reference for understanding **which WordPress query API maps to which database table**.  
Useful for plugin development, performance decisions, and interviews.

---

## All Types of Database Query Notes

### Final Mental Model (Interview-Ready)

# Query -> Table

| Query API | Database Table | Notes |
|----------|----------------|-------|
| `$wpdb` | Custom tables | Direct SQL access (use carefully) |
| `WP_Query` | `wp_posts` | Core content query engine |
| `WP_User_Query` | `wp_users`, `wp_usermeta` | User data & metadata |
| `WP_Comment_Query` | `wp_comments` | Comments & reviews |
| `WP_Term_Query` / `get_terms()` | `wp_terms` (+ tax tables) | Categories, tags, taxonomies |
| `WC_Order_Query` | `wp_posts` | Orders stored as `shop_order` |
| *(Fallback)* `WP_Query` | `wp_posts` | Works for orders, but **not recommended** |

> **Rule:**  
> **Query the table, not the concept.**

---

## WP_Query Overview

### WP_Query queries the `wp_posts` table

Anything stored in `wp_posts` can be queried using `WP_Query`.

### This includes:

- Posts (`post`)
- Pages (`page`)
- Custom Post Types (`product`, `event`, etc.)
- Attachments (`attachment`)
- Revisions
- Menu items (menus are posts internally)
- WooCommerce orders (`shop_order`)
- WooCommerce products (`product`)

---

## WooCommerce Note (Important)

- WooCommerce orders are stored as **posts** (`shop_order`)
- `WP_Query` **can** fetch them
- **Recommended:** use `WC_Order_Query` in production

**Why prefer `WC_Order_Query`?**
- WooCommerce is moving orders from wp_posts to custom tables (HPOS).
- Handles order statuses correctly
- Optimized for large datasets
- Safer against WooCommerce internal changes

---

## Common Mistakes to Avoid

- ❌ Using `WP_Query` for users
- ❌ Using `$wpdb` when a core query API exists
- ❌ Querying concepts instead of tables
- ❌ Ignoring WooCommerce-specific query classes

---

## Quick Memory Hook

> **If the data lives in `wp_posts` → `WP_Query` works**  
> **If not → use the correct query API**

---

_Last updated: keep this file evolving as you learn more._

