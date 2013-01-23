# PHPUNIT-WORDPRESS

This tool contains files required to run unit tests in [WordPress](http://www.wordpress.org) using [PHPUnit](http://www.phpunit.de/manual/current/en/index.html) as the test framework.

## Requirements

* WordPress 3.5
* PHPUnit
* PHP_CodeCoverage
* XDebug
* Ant

## Installation

All you need to do is place the files (``build.php``, ``build.xml``, ``phpunit.xml`` and ``bootstrap.php``) in your WordPress plugins directory. 

For testing purposes, the dummy folder can be placed in the plugins directory.

There is one **important change** that needs to be made to your ``wp-config.php`` file, you'll need to replace ``$table_prefix`` with the value listed in tool's corresponding file.

## How to use

To use the tool, all you need to do is run the build script using the command ``ant -f build.xml`` or just ``ant`` in the plugins directory. 

If you wish to just run your tests without building the WordPress test instance, you can just run the ``phpunit`` command.

For more information visit [my blog post](http://www.davidogilo.co.uk/technical/tdd-in-wordpress-using-phpunit/)
