<?php 
/*
Plugin Name: Dummy Plugin
Plugin URI: http://www.davidogilo.co.uk
Description: A dummy plugin to be used as an example of how to run tests using PHPUnit
Version: 1.0
Author: David Ogilo
Author URI: http://www.davidogilo.co.uk
License: GPL2
*/

require_once( dirname( __FILE__ ) . '/classes/Dummy.php' );

Dummy::getInstance();
?>