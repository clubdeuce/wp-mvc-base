<?php
namespace WPMVCB\Testing
{
	require_once( WPMVCB_SRC_DIR . '/models/class-base-model-js-object.php' );
	
	/**
	 * The test controller for Base_Model_JS_Object.
	 *
	 * @package WPMVCBase_Testing\Unit_Tests
	 * @since WPMVCBase 0.1
	 * @internal
	 */
	class testBaseModelJsObject extends WPMVCB_Test_Case
	{
		private $_script;
		
		public function setUp()
		{
			parent::setUp();
			$this->_script = new \Base_Model_JS_Object(
				'my-super-cool-script',
				'http://my-super-cool-site.com/wp-content/plugins/js/my-super-cool-script.js',
				array( 'jquery', 'my-super-cool-framework' ),
				true,
				true,
				'mySuperCoolL10n',
				array( 'foo' => 'bar' )
			);
		}
		
		public function tearDown()
		{
			wp_deregister_script( 'my-super-cool-script' );
			unset( $this->_script );
		}
		
		/**
		 * @covers Base_Model_JS_Object::__construct
		 */
		public function testPropertyHandle()
		{
			$this->assertClassHasAttribute( '_handle', '\Base_Model_JS_Object' );
			$this->assertSame( 'my-super-cool-script', $this->getReflectionPropertyValue( $this->_script, '_handle' ) );
		}
		
		/**
		 * @covers Base_Model_JS_Object::__construct
		 */
		public function testPropertySrc()
		{
			$this->assertClassHasAttribute( '_src', '\Base_Model_JS_Object' );
			$this->assertSame(
				'http://my-super-cool-site.com/wp-content/plugins/js/my-super-cool-script.js',
				$this->getReflectionPropertyValue( $this->_script, '_src' )
			);
		}
		
		/**
		 * @covers Base_Model_JS_Object::__construct
		 */
		public function testPropertyDeps()
		{
			$this->assertClassHasAttribute( '_deps', '\Base_Model_JS_Object' );
			$this->assertSame(
				array( 'jquery', 'my-super-cool-framework' ),
				$this->getReflectionPropertyValue( $this->_script, '_deps' )
			);
		}
		
		/**
		 * @covers Base_Model_JS_Object::__construct
		 */
		public function testPropertyVer()
		{
			$this->assertClassHasAttribute( '_version', '\Base_Model_JS_Object' );
			$this->assertSame(
				true,
				$this->getReflectionPropertyValue( $this->_script, '_version' )
			);
		}
		
		/**
		 * @covers Base_Model_JS_Object::__construct
		 */
		public function testPropertyInFooter()
		{
			$this->assertClassHasAttribute( '_in_footer', '\Base_Model_JS_Object' );
			$this->assertSame(
				true,
				$this->getReflectionPropertyValue( $this->_script, '_in_footer' )
			);
		}
		
		/**
		 * @covers Base_Model_JS_Object::__construct
		 */
		public function testPropertyLocalizationVar()
		{
			$this->assertClassHasAttribute( '_localization_var', '\Base_Model_JS_Object' );
			$this->assertSame(
				'mySuperCoolL10n',
				$this->getReflectionPropertyValue( $this->_script, '_localization_var' )
			);
		}
		
		/**
		 * @covers Base_Model_JS_Object::__construct
		 */
		public function testPropertyLocalizationArgs()
		{
			$this->assertClassHasAttribute( '_localization_args', '\Base_Model_JS_Object' );
			$this->assertSame(
				array( 'foo' => 'bar' ),
				$this->getReflectionPropertyValue( $this->_script, '_localization_args' )
			);
		}
		
		/**
		 * @covers Base_Model_JS_Object::register
		 */
		public function testMethodRegister()
		{
			global $wp_scripts;
			
			$this->assertTrue( method_exists( 'Base_Model_JS_Object', 'register' ), 'Method register does not exist' );
			$this->_script->register();
			$this->assertTrue( wp_script_is( 'my-super-cool-script', 'registered' ) );
			$this->assertEquals(
				'my-super-cool-script',
				$wp_scripts->registered['my-super-cool-script']->handle,
				'Handle incorrectly registered'
			);
			$this->assertEquals( 
				'http://my-super-cool-site.com/wp-content/plugins/js/my-super-cool-script.js',
				$wp_scripts->registered['my-super-cool-script']->src,
				'Source incorrectly registered'
			);
			$this->assertEquals( 
				array( 'jquery', 'my-super-cool-framework' ),
				$wp_scripts->registered['my-super-cool-script']->deps,
				'Dependencies incorrectly registered'
			);
			$this->assertEquals( 
				true,
				$wp_scripts->registered['my-super-cool-script']->ver,
				'Version incorrectly registered'
			);
		}
		
		/**
		 * @covers Base_Model_JS_Object::enqueue
		 */
		public function testMethodEnqueue()
		{
			$this->assertTrue( method_exists( 'Base_Model_JS_Object', 'enqueue' ) );
			$this->_script->enqueue();
			$this->assertTrue( wp_script_is( 'my-super-cool-script', 'enqueued' ) );
		}
		
		/**
		 * @covers Base_Model_JS_Object::localize
		 */
		public function testMethodLocalize()
		{
			global $wp_scripts;
			
			$this->assertTrue( method_exists( 'Base_Model_JS_Object', 'localize' ) );
			
			wp_register_script( 
				'my-super-cool-script',
				'http://my-super-cool-site.com/wp-content/plugins/js/my-super-cool-script.js',
				array( 'jquery', 'my-super-cool-framework' ),
				true,
				true
			);
			
			$this->_script->localize();
			
			$script = $wp_scripts->query( 'my-super-cool-script' );
			$this->assertEquals( 'var mySuperCoolL10n = {"foo":"bar"};', $script->extra['data'] );
		}
		
		/**
		 * @covers Base_Model_JS_Object::localize
		 */
		public function testLocalizeEmpty()
		{
			$this->assertTrue( method_exists( 'Base_Model_JS_Object', 'localize' ) );
			
			$baz = new \Base_Model_JS_Object( 'baz', 'http://example.com/baz.js', null, false, false );
			
			wp_register_script( 'baz', 'http://example.com/baz.js', null, false, false );
			$this->assertFalse( $baz->localize() );
		}
		
		/**
		 * @covers Base_Model_JS_Object::dequeue
		 */
		public function test_dequeue()
		{
			$this->assertTrue( method_exists( 'Base_Model_JS_Object', 'dequeue' ), 'Method dequeue does not exist' );
			wp_enqueue_script(
				'my-super-cool-script',
				'http://my-super-cool-site.com/wp-content/plugins/js/my-super-cool-script.js',
				array( 'jquery', 'my-super-cool-framework' ),
				true,
				true
			);
			
			$this->assertTrue( wp_script_is( 'my-super-cool-script', 'enqueued', 'Script not dequeued' ) );
			$this->_script->dequeue();
			$this->assertFalse( wp_script_is( 'my-super-cool-script', 'enqueued', 'Script not dequeued' ) );
		}
		
		/**
		 * @covers Base_Model_JS_Object::deregister
		 */
		public function test_deregister()
		{
			$this->assertTrue( method_exists( 'Base_Model_JS_Object', 'deregister' ), 'Method deregister does not exist' );
			wp_register_script(
				'my-super-cool-script',
				'http://my-super-cool-site.com/wp-content/plugins/js/my-super-cool-script.js',
				array( 'jquery', 'my-super-cool-framework' ),
				true,
				true
			);
			$this->assertTrue( wp_script_is( 'my-super-cool-script', 'registered' ), 'Script not registered' );
			$this->_script->deregister();
			$this->assertFalse( wp_script_is( 'my-super-cool-script', 'registered' ), 'Script not deregistered' );
		}
		
		/**
		 * @covers Base_Model_JS_Object::get_handle
		 */
		public function testMethodGetHandle()
		{
			$this->assertTrue( method_exists( $this->_script, 'get_handle' ) );
			$this->assertEquals( 'my-super-cool-script', $this->_script->get_handle() );
		}
		
		/**
		 * @covers Base_Model_JS_Object::get_src
		 */
		public function testMethodGetSrc()
		{
			$this->assertTrue( method_exists( $this->_script, 'get_src' ) );
			$this->assertEquals(
				'http://my-super-cool-site.com/wp-content/plugins/js/my-super-cool-script.js',
				$this->_script->get_src()
			);
		}
		
		/**
		 * @covers Base_Model_JS_Object::get_deps
		 */
		public function testMethodGetDeps()
		{
			$this->assertTrue( method_exists( $this->_script, 'get_deps' ) );
			$this->assertEquals( array( 'jquery', 'my-super-cool-framework' ), $this->_script->get_deps()
			);
		}
		
		/**
		 * @covers Base_Model_JS_Object::get_version
		 */
		public function testMethodGetVersion()
		{
			$this->assertTrue( method_exists( $this->_script, 'get_version' ) );
			$this->assertEquals( true, $this->_script->get_version()
			);
		}
		
		/**
		 * @covers Base_Model_JS_Object::get_in_footer
		 */
		public function testMethodGetInFooter()
		{
			$this->assertTrue( method_exists( $this->_script, 'get_in_footer' ) );
			$this->assertEquals( true, $this->_script->get_in_footer()
			);
		}
		
		/**
		 * @covers Base_Model_JS_Object::get_localization_var
		 */
		public function testMethodGetLocalizationVar()
		{
			$this->assertTrue( method_exists( $this->_script, 'get_localization_var' ) );
			$this->assertEquals( 'mySuperCoolL10n', $this->_script->get_localization_var() );
		}
		
		/**
		 * @covers Base_Model_JS_Object::get_localization_var
		 */
		public function testMethodGetLocalizationVarEmpty()
		{
			$this->assertTrue( method_exists( $this->_script, 'get_localization_var' ) );
			
			//ensure the property is empty
			$this->setReflectionPropertyValue( $this->_script, '_localization_var', null );
			
			$this->assertFalse( $this->_script->get_localization_var() );
		}
		
		/**
		 * @covers Base_Model_JS_Object::get_localization_args
		 */
		public function testMethodGetLocalizationArgs()
		{
			$this->assertTrue( method_exists( $this->_script, 'get_localization_args' ) );
			$this->assertEquals( array( 'foo' => 'bar' ), $this->_script->get_localization_args() );
		}
		
		/**
		 * @covers Base_Model_JS_Object::get_localization_args
		 */
		public function testMethodGetLocalizationArgsEmpty()
		{
			$this->assertTrue( method_exists( $this->_script, 'get_localization_args' ) );
			
			//ensure the property is empty
			$this->setReflectionPropertyValue( $this->_script, '_localization_args', null );
			
			$this->assertFalse( $this->_script->get_localization_args() );
		}
	}
}
?>