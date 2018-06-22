# WP Austin - WordPress Unit Testing

This sample plugin contains a basic meta box for storing a byline, as well as unit tests for testing the entire plugin.

## Local Setup

TODO Fill this in


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
