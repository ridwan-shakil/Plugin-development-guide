# Querying Any Custom Post Type (CPT)

## Core Concept (No Confusion Rule)

In WordPress, **default posts, pages, and all CPTs are treated the same internally**.

* All live in the **`wp_posts`** table
* The only difference is the value of **`post_type`**

> If a function works for `post`, it works for **any CPT**.

---

## Can we query any CPT like normal posts?

✅ **Yes, always**

```php
'post_type' => 'book'
```

Nothing else changes.

---

## Does `get_post()` work for CPTs?

✅ **Yes**

```php
$post = get_post( 123 );
```

* Works for posts, pages, CPTs, attachments
* Does NOT care about post type

---

## Which function to use? (Clear decision table)

| Function             | When to use                            | What it returns      |
| -------------------- | -------------------------------------- | -------------------- |
| `get_post( $id )`    | You know the post ID and need ONE item | `WP_Post \| null`    |
| `get_posts()`        | Simple list, no pagination             | `WP_Post[]`          |
| `WP_Query`           | Advanced queries, pagination, plugins  | `WP_Query` object    |
| `get_page_by_path()` | You know the slug of a CPT             | `WP_Post \| null`    |
| `get_post_meta()`    | Fetch meta of any CPT                  | `mixed`              |
| `get_the_terms()`    | Get taxonomy terms of a CPT            | `WP_Term[] \| false` |

---

## Recommended usage patterns

### ✔ Best practice

* Plugins / complex logic → **`WP_Query`**
* Single known post → **`get_post()`**
* Simple fetch → **`get_posts()`**

### ❌ Avoid

* `query_posts()` → breaks main query

---

## Mental Checklist

* Lives in `wp_posts`? → Query like normal posts
* Need pagination or filters? → `WP_Query`
* Need only one known item? → `get_post()`

---

## One-line takeaway

> **CPTs are not special — WordPress uses one unified post API for all post types.**
