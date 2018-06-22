# WP Austin - WordPress Unit Testing

This sample plugin contains a basic meta box for storing a byline, as well as unit tests for testing the entire plugin.

## Local Setup (Mac)

* Clone this repo locally: `git clone git@github.com:petenelson/wp-unit-tests.git`
* Check your PHP version in your terminal `php --version`. Unit tests need PHP 7, [in case you need to upgrade](https://medium.com/zenchef-tech-and-product/how-to-upgrade-your-version-of-php-to-7-0-on-macos-sierra-e1bfdea55a63).
* Additional info for the following: [https://foresthoffman.com/running-wordpress-phpunit-tests-with-docker/](https://foresthoffman.com/running-wordpress-phpunit-tests-with-docker/)
* Switch the plugin dir and run `composer install` to install PHPUnit.
* Make a new directory and clone the WordPress develop repo: `git clone git@github.com:WordPress/wordpress-develop.git`
* Set the environment variable, example: `export WP_DEVELOP_DIR="/Users/petenelson/projects/wordpress/wordpress-develop/"`
* For a database, I recommend [Docker](https://www.docker.com/) so you don't interfere with any existing database servers.
* Switch to the /docker directory and run `docker-compose up -d` to start the MySQL test database.
* Switch back to the main plugin dir and run `./vendor/bin/phpunit` to run the unit tests.
* Bonus: run `./vendor/bin/phpunit --coverage-html test-coverage-html` to run the unit tests with HTML test coverage in the test-coverage-htmnl directory.

## Travis CI

* Visit [travis-ci.org](https://travis-ci.org) and sign in with your GitHub account.
* Add the repository that's holding your plugin (with a valid .travis.yml file)
* `git push` new code with unit tests
* Profit?

## Frequently Used Assertions

I keep these handy for copy/paste.

```
$this->assertTrue( condition );
$this->assertFalse( condition );
$this->assertEmpty( actual );
$this->assertEquals( expected, actual );
$this->assertContains( needle, haystack );
$this->assertGreaterThan( expected, actual );
$this->assertCount( expectedCount, haystack );
```
