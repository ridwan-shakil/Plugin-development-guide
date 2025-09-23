<?php
open docker desktop app  // Docker desktop must be running while working with Docker
//🔹 Step 1: Create a test database
docker compose exec db mysql -u root -ppassword -e "CREATE DATABASE wordpress_test;"

//🔹 Step 2: Scaffold the test suite [ Now use wp-cli inside your cli container to set up PHPUnit files for your plugin. (Replace unit-test with your plugin’s folder name if different) ]
docker compose run --rm cli wp scaffold plugin-tests unit-test 
  
;//🔹 Step 3: Install the WordPress test suite [ Run the installer script. This will download WordPress core + testing framework into /tmp/ inside the container, and prepare your wordpress_test DB.
// bin/install-wp-tests.sh <db-name> <db-user> <db-pass> [db-host] [wp-version]
docker compose run --rm cli bash bin/install-wp-tests.sh wordpress_test root password

//🔹 Step 4: Install dependencies [ Still inside the container, install PHPUnit + dependencies for your plugin:
docker compose run --rm cli composer install
   composer require --dev yoast/phpunit-polyfills


//🔹 Step 5: Run tests [ Finally, run PHPUnit: ]
docker compose run --rm cli vendor/bin/phpunit


;// if edit docker-compose.yml than a restart may needed
docker compose down
docker compose up -d --build # rebuild image

;// ==============================
docker compose up -d

;## Enter CLI
docker compose exec cli bash
cd /var/www/src/wp-content/plugins/unit-test-three

;## Setup tests (first time)
wp scaffold plugin-tests unit-test-three     ;# only if not scaffolded
bash bin/install-wp-tests.sh wordpress_test wordpress password db_test latest    ;//Install WP test suite (important: run inside cli)

// ✅ Run composer init once per project if there’s no composer.json
// ✅ Then run composer require --dev yoast/phpunit-polyfills
// ✅ No need to run composer install immediately after require
// ✅ Others who clone your repo will run composer install (once) to get your dev dependencies.
composer init
composer require --dev yoast/phpunit-polyfills

;// ## Run tests
phpunit


;// ============= Notes ==============
// Dockerfile.cli 
    # Installs Subversion + unzip + less + bash + curl (Alpine uses apk)
    # Installs PHPUnit (fixed version) inside container globally, so don't need to require it in composer ,unless you prefer to vendor-lock a PHPUnit version per-plugin (then you’d run vendor/bin/phpunit instead of the global one).




