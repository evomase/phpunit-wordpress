<?php 
class Dummy {
	
	private static $_instance;
	
	public static function getInstance()
	{
		if ( empty( self::$_instance ) )
			self::$_instance = new Dummy();
		
		return self::$_instance;
	}
}
?>