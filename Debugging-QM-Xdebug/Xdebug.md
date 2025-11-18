# Xdebug Setup & WordPress Plugin Debugging Guide

This document provides a clean, structured walkthrough for installing, configuring, and using Xdebug to debug WordPress plugins in VS Code.

---

## ## 1. Overview

Xdebug is a PHP extension that enables step‑by‑step debugging, breakpoints, stack traces, and profiling. As a WordPress plugin developer, it allows you to:

* Inspect how your plugin executes
* Step into WordPress core functions
* Track down fatal errors, unexpected behavior, or incorrect logic
* Debug complex hooks and filters
* Follow conditional logic and execution flow

---

# 2. Install Xdebug

## **2.1 Check if Xdebug Is Installed**

Run:

```bash
php -v
```

If you see **with Xdebug**, it's already installed.

If not, proceed below.

## **2.2 Install Xdebug Manually**

Use:

```bash
pecl install xdebug
```

Or download the right version from: [https://xdebug.org/download](https://xdebug.org/download)

---

# 3. Configure `php.ini`

Add the following inside your `php.ini`:

```ini
zend_extension = xdebug

xdebug.mode = debug
xdebug.start_with_request = yes
xdebug.client_port = 9003
xdebug.client_host = 127.0.0.1
xdebug.log = "/tmp/xdebug.log"
```

### **Important Notes:**

* VS Code PHP Debug uses **port 9003**.
* `start_with_request=yes` automatically triggers debugging.
* Logs help diagnose misconfigurations.

Restart Apache / Nginx / PHP-FPM afterwards.

---

# 4. VS Code Setup

Install:

```
Extension: PHP Debug (by xdebug)
```

Create a debug config:

## `.vscode/launch.json`

```json
{
  "version": "0.2.0",
  "configurations": [
    {
      "name": "Listen for Xdebug",
      "type": "php",
      "request": "launch",
      "port": 9003,
      "pathMappings": {
        "/var/www/html": "${workspaceFolder}"
      }
    }
  ]
}
```

Adjust `pathMappings` for your environment.

---

# 5. Start Debugging

## **5.1 Enable Debug Mode in VS Code**

* Click **Run & Debug**
* Select **Listen for Xdebug**
* Start debugging

VS Code now waits for PHP to connect.

## **5.2 Add Breakpoints**

Click the left gutter next to:

```php
do_action( 'init' );
```

Or inside your plugin:

```php
error_log('Plugin Booting...');
```

Any breakpoint will pause execution.

---

# 6. Debugging a WordPress Plugin

## **6.1 Step Into Plugin Load**

Place breakpoints in your plugin’s main file:

```
wp-content/plugins/your-plugin/your-plugin.php
```

Useful spots:

```php
register_activation_hook();
add_action('init', ...);
add_filter('the_content', ...);
```

Reload the page — execution stops at the breakpoint.

---

# 7. Debug Controls (Step Over / Step Into / Step Out)

## **Step Into** (`F11`)

* Enters inside the function being executed
* Use this to study WordPress core or plugin classes

Example: enters inside `add_action()` handler.

## **Step Over** (`F10`)

* Executes the current line without entering functions
* Use this when a function is known to work or irrelevant

## **Step Out** (`Shift+F11`)

* Finishes the current function and returns to the caller
* Use when you accidentally stepped into deep WordPress internals

---

# 8. Debugging Common Plugin Issues

## **8.1 Hooks Not Firing**

Breakpoints to test:

```php
do_action('init');
do_action('wp_loaded');
```

Verify:

* Hook name spelling
* Hook priority
* Plugin load order

## **8.2 Conditional Issues**

Example:

```php
if ( is_user_logged_in() ) {
```

Debug the value of variables using the VARIABLES panel.

## **8.3 Wrong File Paths**

Check:

```php
plugin_dir_path(__FILE__);
```

## **8.4 AJAX Not Firing**

Set breakpoints in:

```php
add_action('wp_ajax_my_action', ...);
add_action('wp_ajax_nopriv_my_action', ...);
```

---

# 9. Inspecting Execution Flow

Inside VS Code you can inspect:

### **Call Stack**

Shows the full list of functions executed.

### **Variables Panel**

See:

* `$post`
* `$wpdb`
* current object state
* all function parameters

### **Watch Panel**

Add:

```
$my_variable
$settings['api_key']
```

---

# 10. Remote Debugging (Live Server)

Add extra config:

```ini
xdebug.discover_client_host = 1
```

Use SSH tunnels or port forwarding if needed.

---

# 11. Profiling (Performance Debugging)

Enable:

```ini
xdebug.mode = profile
```

Generates cachegrind files you can open using tools like **QCacheGrind**.

---

# 12. Tips From Real‑Life Plugin Debugging

* Use breakpoints inside hooks to understand execution timing
* Inspect all data passed into filters
* Debug redirect functions using Step‑Into
* Track down silent failures by following conditional branches
* Enable logging to locate hidden issues
* Use Call Stack to understand complex plugin flow
* Explore WordPress core functions by stepping into them
* Test on slow environments to reproduce real user behavior

---

# 13. Final Notes

Xdebug is the most powerful debugging tool for a WordPress developer. Once configured properly, it saves hours of guessing and allows you to:

* Understand plugin internals
* Fix bugs quickly
* Develop more reliable code
* Follow best practices like an expert
