### Single command to run the project

* Run ``bash install.sh``

### Manual way to run the project.

* Install [Composer](https://getcomposer.org/download/), which is used to install PHP packages.

* Download the [Symfony CLI](https://symfony.com/download) and check that your requirements are met with `symfony check:requirements`

* run `composer install` and start the local web-server with `symfony server:start`

### Run migrations for initialising the tables

``php bin/console doctrine:migrations:migrate -n``

### Load the fixtures for initial data

``php bin/console doctrine:fixtures:load -n``


### Technical requirements

* Install PHP **7.3** or **7.4** and these PHP extensions (which are installed and enabled by default in most PHP 7 installations): [Ctype](https://www.php.net/book.ctype), [iconv](https://www.php.net/book.iconv), [JSON](https://www.php.net/book.json), [PCRE](https://www.php.net/book.pcre), [Session](https://www.php.net/book.session), [SimpleXML](https://www.php.net/book.simplexml), and [Tokenizer](https://www.php.net/book.tokenizer);

You are now fully equipped to start developing! A local sqlite database is already set up to be used with Doctrine, too.


### Postman collections

API endpoints of workers/manager are mentioned in the following path
``docs/postman_collection.json``

### Swagger for API Documentation

For details about the end point documentation can be found in the following swagger file
``docs/swagger.yaml``


### How to run unit test

Test can be run with following command:
``php vendor/bin/codecept run unit``

### How to run api test

In case you are running project on different url or port so configuare right url and port in api.suite.yml, Example below:

```
{
REST:
  "url": http://127.0.0.1:8000/,
}
```


Test can be run with following command:
``php vendor/bin/codecept run api``
