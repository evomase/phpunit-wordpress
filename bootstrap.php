<?php
/**
 * The bootstrap used by PHPUnit and Build
 */

( PHP_SAPI === 'cli' ) || die( 'Access Denied' );

define( 'PHPUNIT_DB_PREFIX', 'phpunit_' );
 
global $wp_rewrite, $wpdb;

require_once( __DIR__ . '/../../wp-load.php' );
require_once( ABSPATH . 'wp-admin/includes/admin.php' );
?>