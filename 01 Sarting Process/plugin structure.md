# Core idea (memorize this)
    includes/ = shared, core, reusable logic, used by both admin & frontend
    admin/ = WordPress dashboard (wp-admin) only
    frontend/ = public site only

### for tiny plugins use : 
    "includes" folder only
### for medium → large plugins 
    : you can use below folders to separate codes
        includes
        admin
        frontend
        

## plugin stracture
    my-plugin.php
        includes/
            ├── Core/
            │   ├── class-plugin.php      // Main plugin controller
            │   ├── class-loader.php      // Registers hooks
            │   ├── class-i18n.php        // Text domain loading
            │   └── class-activator.php   // Activation / deactivation
            │
            ├── Database/
            │   ├── class-schema.php      // Table creation
            │   └── class-repository.php  // CRUD logic
            │
            ├── Services/
            │   ├── class-email.php       // Email logic
            │   └── class-license.php     // Licensing logic
            │
            ├── Utils/
            │   ├── class-sanitizer.php
            │   └── class-validator.php
            │
            └── Contracts/
                └── interface-module.php
                
        admin/
            ├── class-admin.php            // Admin bootstrap
            ├── class-settings.php         // Settings API
            ├── class-metaboxes.php
            ├── class-admin-assets.php
            └── views/
                └── settings-page.php

        frontend/
            ├── class-frontend.php
            ├── class-shortcodes.php
            ├── class-ajax.php
            ├── class-assets.php
            └── views/
                └── shortcode-output.php


