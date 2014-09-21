<?php
/**
 * A singleton class to run some build functions such as creating dummy tables and enable plugins on the fly.
 * 
 * @author David Ogilo
 * @version 1.0
 */
class Build {

	private $db;
	private $tables;
	private $options;
	
	private static $_instance;
	
	/**
	 * Constructor
	 * 
	 * @return void
	 */
	private function __construct()
	{
		global $wpdb;
		$this->db = $wpdb;
		
		$this->setArguments();
		$this->init();
	}
	
	/**
	 * Initiates the build script process.
	 * 
	 * @return void
	 */
	private function init()
	{
		if ( $this->getTables() )
		{
			//Suppress all errors from showing - errors related to foreign keys constraints on tables.
			$this->db->suppress_errors( true );
			
			$this->dropTables();
			
			$this->db->suppress_errors( false );
		}
		
		$this->install();
		
		if ( array_key_exists( 'plugins', $this->options ) && $this->options['plugins'] )
			$this->activatePlugins( $this->options['plugins'] );
		
		$this->success();
	}
	
	/**
	 * Checks the arguments passed to the script and runs functions depending on the arguments passed.
	 * 
	 * @return void
	 */
	private function setArguments()
	{
		$longOptions = array( 'plugins::' );
		
		$this->options = getopt( '', $longOptions );
	}

	/**
	 * Drops dummy PHPUNIT tables;
	 * 
	 * @return boolean
	 */
	private function dropTables()
	{
		if ( !$tables = $this->getTables() ) return false;
		
		$this->printf( '=== DELETING TABLES ===' );
		
		while( !empty( $tables ) )
		{
			$table = current( $tables );
			
			$name = $table['Tables_in_' . DB_NAME];
			$type = $table['Table_type'];
				
			switch( $type )
			{
				case 'VIEW':
					$sql = "DROP VIEW $name";
					break;
						
				default:
					$sql = "DROP TABLE $name";
					break;
			}
				
			if ( $this->db->query( $sql ) )
			{
				$index = key( $tables );
				unset( $tables[$index] );
			}
			
			if ( !next( $tables ) )
				reset( $tables );
			
			$this->printf( $name, false );
		}
		
		$this->printf( PHP_EOL . 'Complete' );
		
		return true;
	}
	
	/**
	 * Returns an array of PHPUNIT tables
	 * 
	 * @return array
	 */
	private function getTables()
	{
		if ( empty( $this->tables ) )
		{
			$sql = "SHOW FULL TABLES IN " . DB_NAME . " WHERE Tables_in_" . DB_NAME . " LIKE '" . PHPUNIT_DB_PREFIX . "%'";
			$this->tables = $this->db->get_results( $sql, ARRAY_A );
		}
		
		return $this->tables;
	}
	
	/**
	 * Installs WordPress
	 * 
	 * @return boolean
	 */
	private function install()
	{
		$this->printf( '=== INSTALLING PHPUNIT WORDPRESS INSTANCE ===' );
		
		if ( is_array( wp_install( 'PHPUNIT', 'phpunit', 'phpunit@example.com', true, null, 'phpunit' ) ) )
			$this->printf( 'Complete' );
		else
		{
			$this->printf( 'Failed' );
			$this->failure();
		}
		
		return true;
	}
	
	/**
	 * Enables plugins on the fly. If plugins are already activated, then nothing happens.
	 * 
	 * @param string $plugins - a ',' delimited string.
	 * @return boolean
	 */
	private function activatePlugins( $plugins )
	{
		$plugins = explode( ',', $plugins );
		
		$this->printf( '=== ACTIVATING PLUGINS ===' );
		
		foreach( $plugins as &$plugin )
		{
			if ( !is_file( WP_PLUGIN_DIR . '/' . $plugin ) )
				$plugin .= '/' . $plugin . '.php';
			
			$this->printf( $plugin );
		}
		
		unset( $plugin );
		
		if ( activate_plugins( $plugins ) !== true )
		{
			$this->printf( 'Failed' );
			$this->failure();
		}

		$this->printf( 'Complete' );
		
		return true;
	}
	
	/**
	 * Print message to the terminal
	 * 
	 * @param string $message
	 * @param boolean $newline
	 * @return void
	 */
	private function printf( $message, $newline = true )
	{
		print PHP_EOL . $message . ( ( $newline )? PHP_EOL : '' );
	}
	
	/**
	 * Exits the program on successful run
	 * 
	 * @return void
	 */
	private function success()
	{
		exit( 0 );
	}
	
	/**
	 * Exits the program on failure
	 * 
	 * @param int $code
	 * @return void
	 */
	private function failure( $code = 1 )
	{
		exit( $code );
	}
	
	/**
	 * Returns the build instance
	 * 
	 * @return Build
	 */
	public static function getInstance()
	{
		if ( empty( self::$_instance ) )
			self::$_instance = new Build();

		return self::$_instance;
	}
}

( PHP_SAPI === 'cli' ) || die( 'Access Denied' );

//Required so that we can install a dummy instance of wordpress
define( 'WP_SITEURL', 'http://example.com' );

//Initiaties the install process by bypassing redirect to install.php
define( 'WP_INSTALLING', true );

//Override default function to prevent sending an email on install
function wp_new_blog_notification( $blogTitle, $blogURL, $userID, $password ){}

require_once( 'bootstrap.php' );
require_once( ABSPATH . 'wp-admin/includes/upgrade.php');

Build::getInstance();
?>