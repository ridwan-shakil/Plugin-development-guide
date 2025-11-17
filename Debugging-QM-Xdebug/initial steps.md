## A Simple Debugging Routine (you can copy-paste into your workflow)

## Enable debugging in wp-config.php:
```php
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true );
define( 'WP_DEBUG_DISPLAY', false );  // hides errors from visitors, logs them instead
```
## Errors now go into wp-content/debug.log.
Use logging instead of guessing:
error_log( 'Reached my_function, $value=' . print_r( $value, true ) );
If nothing happens, check if your function is hooked correctly:
add_action( 'init', 'my_function' ); 
## Maybe you used the wrong hook.
1.	If an AJAX or frontend feature fails, open DevTools → Network tab.
o	Is the AJAX request sent?
o	Did it return an error (like 500)?
2.	If still stuck → use Query Monitor.
o	It shows all hooks that ran, DB queries, REST API calls, errors.

