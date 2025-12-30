# -------- Namespacing --------

## Important clarifications
    ✔ Namespace is declared per file  
    ✔ Files in the same folder usually share the same namespace  
    ✔ Folders define responsibility, not class names  
    ❌ Main plugin bootstrap file → NO namespace  



## Structure
    my-plugin/
    ├── my-plugin.php          (NO namespace)
    ├── includes/
    │   ├── class-one.php      → namespace MyPlugin\Includes\Core;
    │   └── class-loader.php   → namespace MyPlugin\Includes\Core;
    ├── admin/
    │   └── class-settings.php → namespace MyPlugin\Admin;
    └── frontend/
        └── class-assets.php   → namespace MyPlugin\Frontend;



## How to use
### Instantiate classes with full namespace
      $plugin = new \MyPlugin\Includes\Core\Plugin();

### Or use   use  
      use Plugmint\AdminNotes\Plugin;
      $plugin = new Plugin();


# Why to use namespace
    1) To ensure code doesn't conflict with other plugins/themes
    2) prefixing doesn't required inside namespaced files
    3) Enables clean, scalable OOP architecture
