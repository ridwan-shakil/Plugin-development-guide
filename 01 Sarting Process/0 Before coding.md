# 🧠 Rule #1: Decide the PLUGIN IDENTITY before code

## Before writing code, lock these forever: ( Generic names/slug are not accepted )
      Plugin slug	 =  Unique, brand-based   => eg: plugmint-{plugin-name}
      slug = text-domain = Folder name =  Main file.php	
      Prefix	 =  Short brand prefix OR plugin name shortform
      Namespace	 =  Brand/FolderStructure
      
      Plugin name  =  Can be changed anytime 


# Must Remember
## use namespacing to avoid conflicts (eg: brand/****/** )
### 1️⃣ But namespace doesn't cover everything, it will cover only 
      Classes
            function & veriable inside class
      Interfaces
      Traits


## ❌ NOT protected by namespaces
### You MUST prefix these:

     -----------------------------|--------------
      Surface	                |   Why
     -----------------------------|--------------
      Action / filter hook names	Global string
      AJAX actions (wp_ajax_*)	Global string
      REST route names	            Global string
      Option names	            Stored globally
      Meta keys	                  Stored globally
      CPT slugs	                  Global
      Taxonomy slugs	            Global
      Script & style handles	      Global
      Nonce actions	            Global
      Cron hook names	            Global
      Transients	                  Global
