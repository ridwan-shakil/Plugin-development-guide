# WordPress Metadata API – Quick Recall Notes

A concise, professional reference for understanding and using the **WordPress Metadata API** in plugins and themes.

---

## 1. What is Metadata in WordPress?

**Metadata** is additional information attached to an existing WordPress object.

It follows a simple structure:

```
meta_key => meta_value
```

Metadata is **not standalone data** — it always belongs to something else.

---

## 2. Types of Metadata

WordPress natively supports metadata for:

| Object                     | API Name     | Database Table   |
| -------------------------- | ------------ | ---------------- |
| Posts (incl. CPTs, orders) | Post Meta    | `wp_postmeta`    |
| Users                      | User Meta    | `wp_usermeta`    |
| Terms (categories, tags)   | Term Meta    | `wp_termmeta`    |
| Comments                   | Comment Meta | `wp_commentmeta` |

> You should **never access these tables directly** in plugins.

---

## 3. When to Use Metadata API

Use Metadata API when data is:

* Related to a **specific entity** (post, user, term, comment)
* Needs to scale per object
* Not global site-wide configuration

### Examples

* WooCommerce order phone → **Post Meta**
* User company name → **User Meta**
* Category color → **Term Meta**
* Review rating → **Comment Meta**

---

## 4. Metadata API vs Options API

| Metadata API         | Options API        |
| -------------------- | ------------------ |
| Per object           | Global (site-wide) |
| Scales well          | Limited            |
| Used for entity data | Used for settings  |

**Rule of thumb:**

* Settings → Options API
* Object-related data → Metadata API

---

## 5. Core Metadata Functions

### Add Meta

```php
add_post_meta( $post_id, $meta_key, $value, $unique );
```

### Update Meta (Preferred)

```php
update_post_meta( $post_id, $meta_key, $value );
```

### Get Meta

```php
get_post_meta( $post_id, $meta_key, true );
```

### Delete Meta

```php
delete_post_meta( $post_id, $meta_key );
```

Equivalent functions exist for other types:

* `*_user_meta`
* `*_term_meta`
* `*_comment_meta`

---

## 6. Best Practices for Saving Meta

* Always **sanitize on save**
* Always **escape on output**
* Prefer `update_*_meta()` over `add_*_meta()`

Example:

```php
update_post_meta(
    $post_id,
    'rsob_order_note',
    sanitize_text_field( $_POST['order_note'] )
);
```

---

## 7. Meta Keys Naming Rules (WordPress.org Compliant)

### Mandatory

* Use a **unique plugin prefix** everywhere

### Optional

* Use leading `_` to hide meta from UI

### Correct Examples

```text
_rsob_order_note   // hidden + unique
rsob_public_label  // visible + unique
```

### Incorrect Examples

```text
_order_note        // no prefix
_rs_order_note     // weak / non-unique prefix
```

> The underscore `_` does **not** replace a unique prefix.

---

## 8. Getting Meta Correctly (Common Mistake)

❌ Returns array:

```php
get_post_meta( $post_id, 'rsob_order_note' );
```

✅ Returns single value:

```php
get_post_meta( $post_id, 'rsob_order_note', true );
```

---

## 9. Registering Meta (Modern & Professional)

Always register meta when:

* Using REST API
* Supporting Block Editor
* Enforcing permissions

```php
register_post_meta(
    'post',
    'rsob_order_note',
    array(
        'type'              => 'string',
        'single'            => true,
        'sanitize_callback' => 'sanitize_text_field',
        'show_in_rest'      => true,
        'auth_callback'    => function () {
            return current_user_can( 'edit_posts' );
        },
    )
);
```

---

## 10. Meta Query (Filtering by Meta)

```php
$args = array(
    'post_type'  => 'shop_order',
    'meta_query' => array(
        array(
            'key'   => 'rsob_order_note',
            'value' => 'urgent',
        ),
    ),
);

$query = new WP_Query( $args );
```

---

## 11. Performance Notes

* Meta queries are slower than normal queries
* Avoid unindexed meta for heavy filtering
* Consider custom tables for complex datasets

---

## 12. Interview-Ready Summary

> “The Metadata API stores extra data for WordPress objects like posts or users. It should be used for entity-specific data, not global settings. All meta keys must be uniquely prefixed, and meta should be registered for REST and block compatibility.”

---

## 13. Mental Checklist Before Using Meta

* Is this data tied to one object?
* Does it need a unique prefix?
* Should it be hidden from UI?
* Should it be registered?
* Is sanitization handled on save?

---

**End of Notes**
