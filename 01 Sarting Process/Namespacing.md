# -------- Namespacing --------

## Important clarifications
    ✔ Namespace is declared per file  
    ✔ Files in the same folder usually share the same namespace  
    ✔ Folders define responsibility, not class names  
    ❌ Main plugin bootstrap file → NO namespace  
    ✔ Must prefix the namespace so you don't have to prefix anything else
    



## Structure
    my-plugin/
    ├── my-plugin.php          (NO namespace)
    ├── includes/
    │   ├── class-one.php      → namespace prefix\MyPlugin\Includes\Core;
    │   └── class-loader.php   → namespace prefix\MyPlugin\Includes\Core;
    ├── admin/
    │   └── class-settings.php → namespace prefix\MyPlugin\Admin;
    └── frontend/
        └── class-assets.php   → namespace prefix\MyPlugin\Frontend;



## How to use
### Instantiate classes with full namespace
      $plugin = new \prefix\MyPlugin\Includes\Core\Plugin();

### Or use   use  
      use Plugmint\AdminNotes\Plugin;
      $plugin = new Plugin();


# Why to use namespace
    1) To ensure code doesn't conflict with other plugins/themes
    2) prefixing doesn't required inside namespaced files
    3) Enables clean, scalable OOP architecture

### your namespace structure should mirror your folder structure. This follows the PSR-4 autoloading standard, which makes your code predictable and easier to manage.


## Pro Tip: Avoid the "Includes" folder in your Namespace

### While mirroring folders is standard, many professionals map the includes/ folder to the root of their namespace to keep things shorter.

### For example, you could map MyDev\PostRestApi\ directly to your includes/ folder. This would make your namespaces look like this:
        includes/core/ $\rightarrow$ MyDev\PostRestApi\Core
        includes/api/ $\rightarrow$ MyDev\PostRestApi\Api
