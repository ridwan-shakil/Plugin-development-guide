# WordPress Plugin Architecture & Workflow
### 🛡️ General Rules (Standard for All Files)
        •	File Documentation: Always include a PHPDoc header (file description, @package, @version).
        •	Namespacing: Use a unique vendor namespace (e.g., VendorName\PluginName) 
        •	Security Bridge: Always include if ( ! defined( 'ABSPATH' ) ) exit; 
        •	Class-Based:  a single class following Single Responsibility Principle (SRP).
        
________________________________________
## 🚀 1. main-plugin-file.php
### Responsibility: The plugin's "Passport." It identifies the plugin to WordPress and bootstraps the environment.
        •	To Do:
        o	Define the standard Plugin Header (Name, URI, Description, Version, etc.).
        o	Define constant paths/URLs (e.g., PLUGIN_DIR, PLUGIN_URL).
        o	Require the autoloader (e.g., Composer or a custom spl_autoload_register).
        o	Initialize the core Singleton: \Namespace\Core\Plugin::get_instance();.
        •	❌ NOT To Do:
        o	No Namespacing: This file should remain in the global namespace for better compatibility with WP's plugin crawler.
        o	No Logic: Do not register hooks, shortcodes, or HTML here.
________________________________________
## 🏛️ 2. includes/core/class-plugin.php
### Responsibility: The Orchestrator. It sets up the plugin and triggers the Loader.
        •	To Do:
        o	Implement the Singleton Pattern (private constructor, get_instance method).
        o	Instantiate the Loader class within an init_plugin or __construct method.
        •	❌ NOT To Do:
        o	Do not write individual add_action or add_filter calls here. Use the Loader for that.
________________________________________
## ⚙️ 3. includes/core/class-loader.php
### Responsibility: The Wiring Room. This file connects your logic to WordPress hooks.
        •	To Do:
        o	Instantiate Classes: Create instances of your Admin, Frontend, and API classes.
        o	The run() method: Call the register() or init() methods of all sub-classes.
        •	💡 Pro Tip: Use an array to store class instances to keep the code DRY (Don't Repeat Yourself).
        •	❌ NOT To Do:
        o	Do not write the actual logic (SQL, HTML, Processing). Only "hook" the methods from other classes.
________________________________________
## 🛠️ 4. includes/admin/
### Responsibility: Everything related to the WordPress Dashboard (/wp-admin).
        •	To Do:
        o	Handle Menu Pages, Settings Fields, and Meta Boxes.
        o	Security: Always check current_user_can( 'capability' ) before saving data.
        o	Validation: Use Nonces for every form submission or AJAX request.
        •	❌ NOT To Do:
        o	Do not load admin-specific CSS/JS on the frontend. Use admin_enqueue_scripts.
________________________________________
## 🖥️ 5. includes/frontend/
### Responsibility: Public-facing site logic.
        •	To Do:
        o	Handle Shortcodes, Blocks (Gutenberg), and Template redirects.
        o	Sanitization: Use sanitize_text_field(), absint(), etc., for all input.
        o	Escaping: Use esc_html(), esc_attr(), or esc_url() when outputting data.
        •	❌ NOT To Do:
        o	Do not perform heavy database migrations or admin-only logic here.
________________________________________
## 📂 Summary Table: File Responsibilities
        File / Folder	        Primary Goal	                Key Constraint
        Main File	        Bootstrap & Constants	        No Namespacing
        Class Plugin	        Orchestration (Singleton)	No functional logic
        Class Loader	        Registering Hooks	        Only calls add_action/filter
        Admin/	                Backend UI & Settings	        Must check User Capabilities
        Frontend/	        User-facing Output	        Must Escape & Sanitize
