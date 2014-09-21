# PHPUNIT-WORDPRESS

This tool contains files required to run unit tests in [WordPress](http://www.wordpress.org) using [PHPUnit](http://www.phpunit.de/manual/current/en/index.html) as the test framework.

## Requirements

* WordPress 3.5+
* PHPUnit
* PHP_CodeCoverage
* XDebug
* Ant

## Installation

All you need to do is place the files (``build.php``, ``build.xml``, ``phpunit.xml`` and ``bootstrap.php``) in your WordPress plugins directory and replace ``$table_prefix`` in 
``wp-config.php`` with the one below:

``$table_prefix = ( defined( 'PHPUNIT_DB_PREFIX' ) )? PHPUNIT_DB_PREFIX : 'wp_';``  

For testing purposes, the ``dummy`` plugin can be placed in the plugins directory. If you don't want to place the plugin in the plugins directory, then you'll need to edit the 
``phpunit.xml`` file and comment out any reference to the plugin.

## How to use

To use the tool, all you need to do is run the build script using the command ``ant -f build.xml`` or just ``ant`` in the plugins directory. 

If you wish to just run your tests without building the WordPress test instance, you can just run the ``phpunit`` command.

For more information visit [my blog post](http://goo.gl/a2mH1)

## TODO

* Multisite support
