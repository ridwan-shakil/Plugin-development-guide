# Important clarifications
    ✔ Namespace is declared per file
    ✔ Files in the same folder share the same namespace
    ✔ Folder defines responsibility, not class name
    ❌ Main plugin file → no namespace


# Stracture
    my-plugin/
        ├── my-plugin.php          (NO namespace)
        ├── includes/
        │   └── class-one.php      → namespace MyPlugin\Core;
        |   └── class-loader.php   → namespace MyPlugin\Core;
        ├── admin/
        │   └── class-settings.php → namespace MyPlugin\Admin;
        └── frontend/
            └── class-assets.php   → namespace MyPlugin\Frontend;


# how to use 
### Instantiate classes with full namespace / (or use)
     
      $plugin = new \Plugmint\AdminNotes\Plugin();
   
    // or 
     
      use Plugmint\AdminNotes\Plugin;
      $plugin = new Plugin();

