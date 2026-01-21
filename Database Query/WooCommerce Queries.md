
## Quick Decision Table

| Data Type | Recommended Tool |
|---------|------------------|
| Orders | `WC_Order_Query` |
| Products | `WC_Product_Query` |
| Customers | `WC_Customer_Query` |
| Coupons | `WC_Coupon_Query` |
| Order items | Order object methods |
| Reports / analytics | `$wpdb` |

---

## Final Memory Hook

> **WooCommerce data → WC APIs first**  
> **`$wpdb` → last resort only**

---



# WooCommerce Query APIs – Reference Notes

Central reference for querying WooCommerce data **correctly, safely, and future-proof**, especially with HPOS support.

---

## Core Principle

> **Always prefer WooCommerce query APIs over `$wpdb`.**  
> WooCommerce abstractions handle:
- Order statuses
- Meta handling
- Performance optimizations
- HPOS (High-Performance Order Storage) compatibility

---

## WooCommerce Query APIs Overview

### 1. Orders

**Data storage**
- Legacy: `wp_posts` (`shop_order`)
- Modern: Custom tables (HPOS)

✅ **Use:** `WC_Order_Query`  
❌ Avoid: `WP_Query`, `$wpdb`

**Why**
- HPOS-safe
- Correct order status handling
- Backward & forward compatible

---

### 2. Products

**Data storage**
- `wp_posts` (`product`) + product meta

✅ **Use:** `WC_Product_Query`  
❌ Avoid: `WP_Query` for WooCommerce product logic

---

### 3. Customers

**Data storage**
- `wp_users`
- `wp_usermeta`
- WooCommerce lookup tables

✅ **Use:** `WC_Customer_Query`  
❌ Avoid: `WP_User_Query` for WooCommerce-specific needs

---

### 4. Coupons

**Data storage**
- `wp_posts` (`shop_coupon`)

✅ **Use:** `WC_Coupon_Query`

---

### 5. Order Items (Line items, fees, shipping)

**Data storage**
- `woocommerce_order_items`
- `woocommerce_order_itemmeta`

⚠️ No dedicated query class

✅ Preferred:
- `$order->get_items()`
- `$order->get_items( 'line_item' )`

⚠️ `$wpdb` only if absolutely necessary

---

### 6. Reports / Analytics Data

**Data storage**
- `wc_order_stats`
- `wc_customer_lookup`
- `wc_product_meta_lookup`

⚠️ No public WooCommerce query abstraction  
✅ `$wpdb` is acceptable for:
- Reports
- Aggregated data
- Dashboards

---

## HPOS (High-Performance Order Storage)
### WooCommerce is migrating orders from:  wp_posts → custom order tables



✔ WooCommerce query APIs automatically support HPOS  
❌ `$wpdb` queries may break or return incomplete data

> **Never assume orders live in `wp_posts`.**

---

## When `$wpdb` is Acceptable in WooCommerce

Use `$wpdb` **only if all conditions are met**:
- No WooCommerce query API exists
- Data is reporting or analytics-based
- Schema is fully understood
- HPOS impact is considered

---



_Last updated: keep revising as WooCommerce evolves._
