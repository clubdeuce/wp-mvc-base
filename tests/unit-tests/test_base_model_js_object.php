<?php

require_once( dirname( __FILE__ ) . '../../../models/base_model_js_object.php' );

class TestBaseModelJsObject extends WP_UnitTestCase
{
	private $_script;
	
	public function SetUp()
	{
		$this->_script = new Base_Model_JS_Object(
			'my-super-cool-script',
			'http://my-super-cool-site.com/wp-content/plugins/js/my-super-cool-script.js',
			array( 'jquery', 'my-super-cool-framework' ),
			true,
			'mySuperCoolL10n',
			array( 'foo' => 'bar' )
		);

		$this->_script->register();
		$this->_script->localize();
	}
	
	public function testRegister()
	{
		$this->assertArrayHasKey( 'my-super-cool-script', $GLOBALS['wp_scripts']->registered );
	}
	
	public function testRegisterHandle()
	{
		$this->assertEquals( 'my-super-cool-script', $GLOBALS['wp_scripts']->registered['my-super-cool-script']->handle );
	}
	
	public function testRegisterSrc()
	{
		$this->assertEquals( 
			'http://my-super-cool-site.com/wp-content/plugins/js/my-super-cool-script.js',
			$GLOBALS['wp_scripts']->registered['my-super-cool-script']->src
		);
	}
	
	public function testRegisterDeps()
	{
		$this->assertEquals( 
			array( 'jquery', 'my-super-cool-framework' ),
			$GLOBALS['wp_scripts']->registered['my-super-cool-script']->deps
		);
	}
	
	public function testRegisterVer()
	{
		$this->assertEquals( 
			true,
			$GLOBALS['wp_scripts']->registered['my-super-cool-script']->ver
		);
	}
	
	public function testLocalize()
	{
		//print_r($GLOBALS);
	}
}
?>