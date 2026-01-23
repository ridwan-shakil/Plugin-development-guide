# WordPress REST API – JSON Schema Notes

## What is JSON Schema in WordPress REST API?

In WordPress, JSON Schema defines the **contract** between a REST API endpoint and its consumers.

It controls:

* What data is **accepted**
* How data is **sanitized & validated**
* What data is **returned**
* Which fields are **public vs protected**

Schema is not just validation — it is the **single source of truth** for REST endpoints.

---

## Where Schema is Used

1. `register_rest_route()` → `args`
2. Custom REST Controllers → `get_item_schema()`
3. Core WordPress & WooCommerce REST APIs

---

## Basic Schema Example

```php
'args' => array(
	'email' => array(
		'type'     => 'string',
		'required' => true,
	),
)
```

WordPress will:

* Reject missing fields
* Reject wrong data types
* Pass only valid data to the callback

---

## Core Schema Properties (Most Used)

### type

Defines the data type.

```php
'type' => 'string'
```

Allowed: `string`, `integer`, `number`, `boolean`, `array`, `object`

---

### required

Forces the field to exist in the request.

```php
'required' => true
```

---

### sanitize_callback

Runs **before** the endpoint callback.

```php
'sanitize_callback' => 'sanitize_text_field'
```

---

### validate_callback

Custom validation logic.

```php
'validate_callback' => function( $value ) {
	return is_email( $value );
}
```

---

### default

Sets a fallback value if field is missing.

```php
'default' => 10
```

---

## Advanced Schema (Controller-Based)

### get_item_schema()

Used in professional plugins and core controllers.

```php
public function get_item_schema() {
	return array(
		'type'       => 'object',
		'properties' => array(
			'id' => array(
				'type'     => 'integer',
				'readonly' => true,
			),
		),
	);
}
```

This schema controls **both input and output**.

---

## Important Advanced Properties

### readonly

* Field can be returned
* Field cannot be sent by client

Used for:

* IDs
* timestamps
* computed values

---

### enum

Restricts allowed values.

```php
'enum' => array( 'pending', 'completed', 'failed' )
```

Invalid values are automatically rejected.

---

### context

Controls field visibility.

```php
'context' => array( 'view', 'edit' )
```

* `view` → public response
* `edit` → authenticated/admin only

---

## Arrays & Nested Objects

```php
'items' => array(
	'type'  => 'array',
	'items' => array(
		'type' => 'integer',
	),
)
```

Used heavily in WooCommerce schemas.

---

## Why Schema is Important

* Eliminates manual `$_POST` checks
* Centralizes validation & sanitization
* Prevents invalid API usage
* Makes APIs predictable and secure
* Enables REST API discovery & documentation

---

## Mental Model

```
Request
  ↓
Schema (validate + sanitize)
  ↓
Callback (business logic only)
  ↓
Schema-based response
```

---

## Best Practices

* Never duplicate validation inside callbacks
* Treat schema as the **single source of truth**
* Prefer controller-based schemas for complex APIs
* Always define types and sanitization
* Use `enum` instead of conditional logic where possible

---

## When to Use Advanced Schema

* License activation APIs
* WooCommerce custom endpoints
* Admin ↔ frontend communication
* Replacing admin-ajax with REST

---

## Key Takeaway

JSON Schema is not optional in professional WordPress REST APIs —
it is the foundation of **clean, secure, and scalable plugins**.
