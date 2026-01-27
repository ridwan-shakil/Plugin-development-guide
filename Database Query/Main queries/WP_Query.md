# WP_Query – Quick Reference Notes

## What is WP_Query?

`WP_Query` is WordPress’s core class for querying **post-type data** from the database in a safe, flexible, and WP-native way.

> Mental model: **Args → WP_Query → Loop**

---

## What data can WP_Query fetch?

### ✅ Supported (from `wp_posts` table)

* Posts
* Pages
* Custom Post Types (CPTs)
* Attachments
* Revisions

### ❌ Not supported

* Users → `WP_User_Query`
* Terms / Categories → `WP_Term_Query`
* Options → `get_option()`
* WooCommerce Orders (HPOS) → WC Query APIs

---

## When to use WP_Query

Use `WP_Query` when:

* You need a **custom query**
* You are inside a **plugin, shortcode, widget, or custom logic**
* You **do not want to modify the main query**

Do NOT use when:

* You want to change the main query → use `pre_get_posts`
* Querying users, terms, or WooCommerce orders

---

## Basic usage example

```php
$args = array(
    'post_type'      => 'post',
    'posts_per_page' => 5,
);

$query = new WP_Query( $args );

if ( $query->have_posts() ) {
    while ( $query->have_posts() ) {
        $query->the_post();
        the_title();
    }
    wp_reset_postdata();
}
```

⚠️ Always call `wp_reset_postdata()` after a custom query.

---

## Commonly used arguments

### Post targeting

```php
'post_type'      => 'book'
'post_status'    => 'publish'
'p'              => 123
'post__in'       => [1,2,3]
'post__not_in'   => [4,5]
```

### Tax query (categories, tags, custom taxonomies)

```php
'tax_query' => array(
    array(
        'taxonomy' => 'genre',
        'field'    => 'slug',
        'terms'    => 'fiction',
    ),
)
```

### Meta query (post meta)

```php
'meta_query' => array(
    array(
        'key'     => 'price',
        'value'   => 100,
        'compare' => '>=',
        'type'    => 'NUMERIC',
    ),
)
```

⚠️ Meta queries can be slow if overused.

---

## Pagination

```php
'paged' => get_query_var( 'paged', 1 ),
```

Required for proper pagination.

---

## WP_Query vs other methods

| Method          | Use               |
| --------------- | ----------------- |
| `WP_Query`      | ✅ Best & flexible |
| `get_posts()`   | Simple, limited   |
| `query_posts()` | ❌ Never use       |

---

## Modifying the main query

Use `pre_get_posts` instead of `WP_Query`:

```php
add_action( 'pre_get_posts', function( $query ) {
    if ( ! is_admin() && $query->is_main_query() ) {
        $query->set( 'post_type', 'book' );
    }
});
```

---

## Performance tips

* Avoid heavy `meta_query`
* Use indexed meta keys
* Limit fields when possible:

```php
'fields' => 'ids'
```

* Cache results if reused

---

## Final mental checklist

* Lives in `wp_posts`? → `WP_Query`
* Main query change? → `pre_get_posts`
* Users? → `WP_User_Query`
* Woo orders? → WC APIs
