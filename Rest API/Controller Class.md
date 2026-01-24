# WordPress REST API Controller Classes

A concise, practical reference for building **REST API controller classes** in WordPress plugins, following core conventions and scalable architecture.

---

## 1. What is a REST API Controller?

A **REST controller** is a PHP class that:

* Owns **one resource** (noun-based)
* Defines **routes** for that resource
* Handles **permissions, validation, and responses**

> **Rule:** 1 Controller = 1 Resource (not per route, not per method)

Examples of resources:

* books
* orders
* reviews
* notes

---

## 2. Why Use Controller Classes?

Compared to raw `register_rest_route()` calls:

* Cleaner OOP structure
* Matches WordPress core REST architecture
* Easier permission control
* Scales well for large plugins
* Encouraged by WordPress documentation

WordPress core examples:

* `WP_REST_Posts_Controller`
* `WP_REST_Comments_Controller`
* `WP_REST_Users_Controller`

---

## 3. Base Class

All custom controllers extend:

```
WP_REST_Controller
```

This provides:

* Standard method patterns
* Helper methods
* Consistent API behavior

---

## 4. Required Controller Properties

Each controller defines:

```php
protected $namespace = 'my-plugin/v1';
protected $rest_base = 'books';
```

This creates endpoints like:

```
/wp-json/my-plugin/v1/books
/wp-json/my-plugin/v1/books/{id}
```

### Mental Model

* `namespace` → plugin + versioning
* `rest_base` → resource name (plural)

---

## 5. register_routes()

Controllers do nothing automatically.
You **must** register routes manually.

```php
public function register_routes() {
    register_rest_route( ... );
}
```

Routes define:

* URL pattern
* HTTP methods
* Callback methods
* Permission callbacks

---

## 6. Standard Controller Methods (Best Practice)

| Purpose           | Method Name             |
| ----------------- | ----------------------- |
| List items        | `get_items()`           |
| Get single item   | `get_item()`            |
| Create item       | `create_item()`         |
| Update item       | `update_item()`         |
| Delete item       | `delete_item()`         |
| Permission checks | `*_permissions_check()` |

These mirror WordPress core patterns.

---

## 7. Permissions (Mandatory)

Never trust REST requests.

Example:

```php
public function get_items_permissions_check( $request ) {
    return current_user_can( 'manage_options' );
}
```

Or return an error:

```php
return new WP_Error(
    'rest_forbidden',
    __( 'Access denied', 'text-domain' ),
    [ 'status' => 403 ]
);
```

---

## 8. Request → Response Flow

1. Request hits REST route
2. Permission callback runs
3. Controller method executes
4. Data is prepared
5. Response returned

Use:

```php
return rest_ensure_response( $data );
```

---

## 9. One Controller, Multiple Routes

A single controller can register multiple routes for the **same resource**:

```
/books
/books/{id}
```

Different routes:

* May allow different HTTP methods
* Still belong to the same controller

---

## 10. Nested Routes & Resources

Example:

```
/books/{id}/reviews
```

### Key Rule

> **Resource = last noun, not URL structure**

So:

* Resource → `reviews`
* Controller → `Reviews_Controller`

Even though the URL contains `books/{id}`.

Same rule applies to:

* `/orders/{id}/notes`
* `/posts/{id}/comments`

---

## 11. Controller Naming Rules

### Recommended

```php
Books_Controller
Orders_Controller
Reviews_Controller
Notes_Controller
```

### Avoid

```php
Books_Reviews_Controller
Orders_Notes_Controller
```

### Why?

* Controllers represent **resources**, not relationships
* Resources may be reused later
* Matches WordPress core style

### Rare Exception

Use scoped names **only if the resource can never exist independently**.

---

## 12. Folder Structure (Best Practice)

```
plugin-name/
├── plugin-name.php
├── includes/
│   └── Rest/
│       ├── Books_Controller.php
│       ├── Orders_Controller.php
│       ├── Reviews_Controller.php
│       └── Rest_Loader.php
```

---

## 13. Rest Loader Pattern

Controllers must be instantiated manually:

```php
add_action( 'rest_api_init', function () {
    ( new Books_Controller() )->register_routes();
    ( new Orders_Controller() )->register_routes();
});
```

Best practice: centralize this logic in a `Rest_Loader` class.

---

## 14. Final Mental Rules (Memorize)

* 1 Controller = 1 Resource
* Controller names are **resource-based**, not route-based
* Nested URLs ≠ same resource
* Permissions are mandatory
* Routes are registered manually
* Follow WordPress core patterns

---

## 15. Self-Check Questions

* What resource am I CRUD-ing?
* Can this resource exist independently?
* Does this match WP core style?

If yes → your controller design is correct.

---

**Use this note as a reference when designing REST APIs in WordPress plugins.**
