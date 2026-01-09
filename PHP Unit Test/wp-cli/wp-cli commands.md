# 📘 WP-CLI Cheat Sheet (for Plugin Developers)

## 🔹 Basics
    wp core version        # check WP version
    wp --info              # PHP & WP-CLI environment info
________________________________________
## 🔹 Plugin Commands
      wp plugin list                      # show all plugins
      wp plugin activate my-plugin        # activate your plugin
      wp plugin deactivate my-plugin      # deactivate your plugin
      wp plugin delete my-plugin          # delete plugin
________________________________________
## 🔹 Theme Commands
    wp theme list
    wp theme activate twentytwentyfive
________________________________________
## 🔹 Database
    wp db export mydb.sql               # export DB
    wp db import mydb.sql               # import DB
    wp db query "SELECT * FROM wp_options LIMIT 5;"   # run SQL
________________________________________
## 🔹 Users
    wp user list
    wp user create tester tester@example.com --role=administrator --user_pass=12345
    wp user delete 3 --reassign=1
________________________________________
## 🔹 Posts & CPTs
    wp post create --post_type=post --post_title="Hello World" --post_status=publish
    wp post list --post_type=page --format=ids
________________________________________
## 🔹 Scaffold (developer shortcuts 🚀)
    wp scaffold plugin my-plugin              # create plugin boilerplate
    wp scaffold post-type book --plugin=my-plugin
    wp scaffold taxonomy genre --plugin=my-plugin
________________________________________
## 🔹 Debug / Maintenance
    wp cache flush
    wp option get siteurl
    wp option update blogdescription "New description"
________________________________________
## 👉 That’s all you really need as a plugin dev. You’ll mostly use:
    •	plugin activate/deactivate while testing
    •	db export/import for backups
    •	scaffold for quick boilerplate

