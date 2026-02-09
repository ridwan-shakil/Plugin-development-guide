## follow this article : https://medium.com/soluto-engineering/testing-wordpress-plugins-can-be-fun-d926a20452b0
## clone this repo : https://github.com/Soluto/wordpress-plugin-tests-template

.yml file need some modifications

    Fork/Clone this repo
    Replace the plugin code under src folder.
    Open tests\bootstrap.php and change the plugin name (look for the TODO).
    Write some tests under the tests folder.
    Add relevant libraries for your tests to the composer.json file.

## run this : 
    docker-compose up --build -d        ( first time )  /  rom next time use :     docker-compose up -d
    docker-compose run --rm wordpress vendor/bin/phpunit
Creates a new container each time → runs tests → deletes the container (--rm)
