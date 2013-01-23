<?php
/**
 * The bootstrap used by PHPUnit and Build
 */

( PHP_SAPI === 'cli' ) || die( 'Access Denied' );

define( 'PHPUNIT_DB_PREFIX', 'phpunit_' );
defined( 'PHPUNIT_BUILD_SETUP' ) || define( 'PHPUNIT_BUILD_SETUP', false );
 
global $wp_rewrite, $wpdb;

//Required for code coverage to run.
//define( 'WP_MAX_MEMORY_LIMIT', '1024M' );
define( 'WP_MEMORY_LIMIT', '100M' );

require_once( dirname( __FILE__ ) . '/../../../wp-load.php' );
require_once( ABSPATH . 'wp-admin/includes/admin.php' );

if ( !PHPUNIT_BUILD_SETUP ) wp_set_current_user( 1 );
?>