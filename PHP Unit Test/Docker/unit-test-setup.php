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
docker compose up -d --build


;// WordPress test suite
# inside cli container
svn co https://develop.svn.wordpress.org/tags/$(wp core version)/tests/phpunit/ /tmp/wordpress-tests

cp /tmp/wordpress-tests/wp-tests-config-sample.php /tmp/wordpress-tests/wp-tests-config.php
nano /tmp/wordpress-tests/wp-tests-config.php

  
