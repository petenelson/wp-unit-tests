# WP Austin - WordPress Unit Testing

This sample plugin contains a basic meta box for storing a byline, as well as unit tests for testing the entire plugin.

## Local Setup

* Check your PHP version in your terminal `php --version`. Unit tests need PHP 7, [in case you need to upgrade](https://medium.com/zenchef-tech-and-product/how-to-upgrade-your-version-of-php-to-7-0-on-macos-sierra-e1bfdea55a63).
* Additional info for the following: [https://foresthoffman.com/running-wordpress-phpunit-tests-with-docker/](https://foresthoffman.com/running-wordpress-phpunit-tests-with-docker/)
* Switch back to the plugin dir and run `composer install` to install PHPUnit.
* Make a new folder and clone the WordPress develop repo: `git clone git@github.com:WordPress/wordpress-develop.git`
* Set the environment variable, example: `export WP_DEVELOP_DIR="/Users/petenelson/projects/wordpress/wordpress-develop/"`
* For a database, I recommend [Docker](https://www.docker.com/) so you don't interfere with any existing database servers.
* Switch to the /docker folder and run `docker-compose up -d` to start the MySQL test database.
* Switch back to the main plugin dir and run `./vendor/bin/phpunit` to run the unit tests.

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
