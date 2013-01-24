<?php
/**
 * A singleton dummy class used for test purposes.
 * 
 * @author David Ogilo
 */ 
class Dummy {
	
	private static $_instance;
	
	/**
	 * Returns an instance of the Dummy class
	 * 
	 * @return Dummy
	 */
	public static function getInstance()
	{
		if ( empty( self::$_instance ) )
			self::$_instance = new Dummy();
		
		return self::$_instance;
	}
}
?>