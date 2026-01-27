# CPT REST API (`show_in_rest`) vs Custom REST API

This note clears the confusion between **CPT REST support** and **custom REST endpoints** in WordPress.

---

## 1️⃣ `show_in_rest => true`

### What it is

Enables WordPress **internal REST support** for a post type.

```php
'show_in_rest' => true,
'rest_base'    => 'books',
```

### What it gives you

* Gutenberg (Block Editor) support
* WordPress-managed REST endpoints:

  * `/wp-json/wp/v2/books`
  * `/wp-json/wp/v2/books/{id}`
* Built-in CRUD, permissions, schema, autosave, previews
* Used by **WordPress core**, not just you

### Intended purpose

> **Internal / admin-facing API** used by WordPress itself.

### Pros

* Zero setup
* Fully integrated with core
* Stable and future-proof
* Required for modern CPTs

### Cons

* Exposes a lot of fields by default
* Not safe to remove fields
* Not suitable as a strict public API
* Shared contract (breaking it breaks Gutenberg)

---

## 2️⃣ Custom REST API (`register_rest_route()`)

### What it is

Your **own API contract** for frontend, public, or external use.

```php
register_rest_route( 'plugmint/v1', '/books', [ ... ] );
```

### What it gives you

* Full control over:

  * Fields
  * Schema
  * Permissions
  * Versioning
* Clean, minimal JSON responses
* Safe for public consumption

### Intended purpose

> **Public / plugin-specific API**.

### Pros

* Precise data exposure
* No Gutenberg risk
* Versionable and maintainable
* Professional plugin architecture

### Cons

* More code
* You manage queries, schema, permissions

---

## 3️⃣ When to use which one

| Situation                   | Use               |
| --------------------------- | ----------------- |
| Admin editing / Gutenberg   | `show_in_rest` ✅  |
| Internal WordPress features | `show_in_rest` ✅  |
| Public JSON API             | Custom endpoint ✅ |
| Frontend app / mobile app   | Custom endpoint ✅ |
| Need strict field control   | Custom endpoint ✅ |

---

## 4️⃣ Key rule (important)

> **Never treat CPT REST endpoints as your public API.**

* CPT REST = WordPress infrastructure
* Custom REST = Your plugin API

They serve **different responsibilities**.

---

## 5️⃣ Recommended architecture

```text
CPT: book
├─ /wp-json/wp/v2/books          (WordPress internal)
└─ /wp-json/plugmint/v1/books    (Public / plugin API)
```

Same data source, different contracts.

---

## 6️⃣ Final takeaway

* `show_in_rest` is **mandatory** for modern CPTs
* Custom REST endpoints are **mandatory** for clean public APIs
* They are **complementary**, not alternatives

## rest_controller_class = custom_controllr_class (for internal api)
    show_in_rest = registers internal CPT REST endpoints
    rest_controller_class = controls how those endpoints behave
    You do not register endpoints again
    This is NOT a replacement for custom APIs
    
## Reality check:
### 80–90% of plugins never need a custom rest_controller_class.
t’s an advanced internal tool, not a default choice.
