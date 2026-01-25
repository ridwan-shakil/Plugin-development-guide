# REST API Controller – Workflow & Mental Model

This note explains the **entire WordPress REST API controller workflow** using a **minimal controller skeleton**, focusing on **how methods are connected**, not full code.

Use this as a **quick refresher** before writing or reviewing REST controllers.

---

## Core Idea

> **1 REST Controller = 1 Resource** (books, orders, reviews, notes)

A controller:

* Defines routes
* Secures access
* Validates data
* Converts DB objects into REST-safe responses

---

## High-Level Request Flow

```
Request
 ↓
Route
 ↓
Permission Check
 ↓
Schema Validation
 ↓
Database Operation
 ↓
Response Preparation
 ↓
REST Response
```

---

## Minimal REST Controller Skeleton (Conceptual)

```php
class Books_Controller extends WP_REST_Controller {
```

Each method below plays a **specific role** in the pipeline.

---

## 1. __construct()

**Purpose:** Controller identity

* Define `$namespace`
* Define `$rest_base`

**Mental model:**

> “Who am I and which resource do I own?”

---

## 2. register_routes()

**Purpose:** API entry points

* Registers `/books`
* Registers `/books/{id}`
* Attaches callbacks
* Attaches permission checks
* Attaches schema-based args

**Mental model:**

> “These URLs belong to me.”

⚠️ Without this method, the controller does nothing.

---

## 3. get_items( $request )

**Route:** `GET /books`

**Purpose:** Return a collection

Conceptual steps:

1. Read query params
2. Fetch multiple records
3. Loop items
4. Delegate formatting
5. Return list

**Mental model:**

> “Give me all books.”

---

## 4. get_item( $request )

**Route:** `GET /books/{id}`

**Purpose:** Return a single resource

Conceptual steps:

1. Read ID from request
2. Fetch record
3. Delegate formatting
4. Return response

**Mental model:**

> “Give me one book.”

---

## 5. create_item( $request )

**Route:** `POST /books`

**Purpose:** Create resource

Conceptual steps:

1. Receive schema-validated data
2. Insert into DB
3. Fetch created record
4. Return formatted response

**Mental model:**

> “Create a new book.”

---

## 6. update_item( $request )

**Route:** `PUT /books/{id}`

**Purpose:** Update resource

Conceptual steps:

1. Read ID + input
2. Update DB
3. Fetch updated record
4. Return formatted response

**Mental model:**

> “Update this book.”

---

## 7. delete_item( $request )

**Route:** `DELETE /books/{id}`

**Purpose:** Delete resource

Conceptual steps:

1. Permission check
2. Delete record
3. Return confirmation

**Mental model:**

> “Remove this book.”

---

## 8. Permission Check Methods

Example:

* `get_items_permissions_check()`
* `create_item_permissions_check()`

**Purpose:** Security gate

* Runs before callback
* Allows or blocks access

**Mental model:**

> “Is the user allowed to do this?”

---

## 9. get_item_schema()

**Purpose:** Data contract

Defines:

* Field names
* Data types
* Context (`view`, `edit`)
* Required fields
* Validation & sanitization

**Mental model:**

> “This is what ONE book looks like in my API.”

🔥 Single source of truth for the resource.

---

## 10. prepare_item_for_response( $item, $request )

**Purpose:** Serializer (MOST IMPORTANT)

* Convert raw DB object → REST-safe data
* Apply schema rules
* Respect context
* Enable `_fields`

**Mental model:**

> “Format ONE book correctly.”

♻️ Reused by:

* get_items
* get_item
* create_item
* update_item

---

## 11. prepare_response_for_collection( $response )

**Purpose:** Collection adapter

* Converts single REST response into array
* Removes headers & links
* Makes it safe for collections

**Mental model:**

> “Make this response fit inside a list.”

---

## Full Lifecycle Summary

```
Route hit
 ↓
Permission check
 ↓
Schema validation
 ↓
Database query
 ↓
prepare_item_for_response()
 ↓
prepare_response_for_collection() (if list)
 ↓
rest_ensure_response()
```

---

## Final Mental Rules (Memorize)

* One controller per resource
* Routes define **where**
* Permissions define **who**
* Schema defines **what**
* prepare_item_for_response defines **how**

---

**Use this note as a mental map before implementing any REST API controller in WordPress.**
