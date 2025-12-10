### How to know where to use Strategy Pattern?
  There are three clear signals you can look for.
  
## ✅ Signal 1: You have multiple ways to do the same job
    Example from WP plugin world:
    Export data as JSON, CSV, TXT
    Multiple api to do same type job
    Save data using post meta, custom table, or CPT
    Send emails via wp_mail, SMTP, or API

## ✅ Signal 2: You want to add new variations without editing old code
    Example:
    You release a plugin with JSON & CSV export.
    Later you add XML.
    Without Strategy, you edit a huge if/else block.
    With Strategy:
    You create a new class XmlExport
    Everything else stays untouched
    This is called Open/Closed Principle
    (open for extension, closed for modification)
    
## ✅ Signal 3: You want to clean messy code
    If you ever think:
    “This code is getting too bloated.”
    Strategy helps by splitting each behavior into its own class.
