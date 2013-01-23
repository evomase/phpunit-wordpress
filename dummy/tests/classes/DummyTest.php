<?php 
class DummyTest extends PHPUnit_Framework_TestCase {
	
	public function testGetInstance()
	{
		$this->assertInstanceOf( 'Dummy', Dummy::getInstance() );
	}
}
?>