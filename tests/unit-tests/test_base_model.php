<?php
namespace WPMVCB\Testing
{
	require_once WPMVCB_SRC_DIR . '/helpers/class-base-helpers.php';
	require_once WPMVCB_SRC_DIR . '/models/class-base-model.php';
	
	/**
	 * Base Model Test Stub
	 *
	 * @internal
	 * @since 0.1
	 */
	class TestStubBaseModel extends \Base_Model
	{
		public function __construct()
		{
		}
	}
	
	/**
	 * Base Model Test Class
	 *
	 * @internal
	 * @since 0.1
	 */
	class TestBaseModel extends WPMVCB_Test_Case
	{
		public function SetUp()
		{
			parent::setUp();
			$this->_model = new TestStubBaseModel;
		}
		
		public function tearDown()
		{
			unset( $this->_model );
		}
		
		/**
		 * @covers Base_Model::get_css
		 */
		public function testMethodGetCss()
		{
			$this->assertClassHasAttribute( 'css', '\Base_Model' );
			$this->assertTrue( method_exists( $this->_model, 'get_css' ) );
			$this->setReflectionPropertyValue( $this->_model, 'css', array( 'foo_css' => array( 'handle' => 'bar_css' ) ) );
			
			$this->assertEquals(
				array( 'foo_css' => array( 'handle' => 'bar_css' ) ),
				$this->_model->get_css( 'http://my-super-cool-site' )
			);
		}
		
		/**
		 * @covers Base_Model::get_css
		 */
		public function testMethodGetCssEmpty()
		{
			$this->assertTrue( method_exists( $this->_model, 'get_css' ) );
			$this->assertFalse( $this->_model->get_css() );
		}
		
		/**
		 * @covers Base_Model::get_admin_css
		 */
		public function testMethodGetAdminCss()
		{
			$this->assertClassHasAttribute( 'admin_css', '\Base_Model' );
			$this->assertTrue( method_exists( $this->_model, 'get_admin_css' ) );
			$this->setReflectionPropertyValue( $this->_model, 'admin_css', array( 'foo_admin_css' => array( 'handle' => 'bar_admin_css' ) ) );
			$this->assertEquals(
				array( 'foo_admin_css' => array( 'handle' => 'bar_admin_css' ) ),
				$this->_model->get_admin_css( 'http://my-super-cool-site' )
			);
		}
		
		/**
		 * @covers Base_Model::get_admin_css
		 */
		public function testMethodGetAdminCssEmpty()
		{
			$this->assertTrue( method_exists( $this->_model, 'get_admin_css' ) );
			$this->assertFalse( $this->_model->get_admin_css() );
		}
		
		/**
		 * @covers Base_Model::get_scripts
		 */
		public function testMethodGetScripts()
		{
			$this->assertClassHasAttribute( 'scripts', '\Base_Model' );
			$this->assertTrue( method_exists( $this->_model, 'get_scripts' ) );
			//global $post;
			
			$this->setReflectionPropertyValue( $this->_model, 'scripts', array ( 'foo_scripts' => 'bar_scripts' ) );
			$this->assertEquals(
				array ( 'foo_scripts' => 'bar_scripts' ),
				$this->_model->get_scripts()
			);
		}
		
		/**
		 * @covers Base_Model::get_scripts
		 */
		public function testMethodGetScriptsEmpty()
		{
			$this->assertTrue( method_exists( $this->_model, 'get_scripts' ) );
			$this->assertFalse( $this->_model->get_scripts() );
		}
		
		/**
		 * @covers Base_Model::get_admin_scripts
		 */
		public function testMethodGetAdminScripts()
		{
			$this->assertClassHasAttribute( 'admin_scripts', '\Base_Model' );
			$this->assertTrue( method_exists( $this->_model, 'get_admin_scripts' ) );
			
			//global $post;
			$this->setReflectionPropertyValue( $this->_model, 'admin_scripts', array( 'foo_admin_scripts' => 'bar_admin_scripts' ) );
			$this->assertEquals(
				array( 'foo_admin_scripts' => 'bar_admin_scripts' ),
				$this->_model->get_admin_scripts()
			);
		}
		
		/**
		 * @covers Base_Model::get_admin_scripts
		 */
		public function testMethodGetAdminScriptsEmpty()
		{
			$this->assertTrue( method_exists( $this->_model, 'get_admin_scripts' ) );
			$this->assertFalse( $this->_model->get_admin_scripts() );
		}
		
		/**
		 * @covers Base_Model::add_metabox
		 */
		public function testMethodAddMetabox()
		{
			$this->assertClassHasAttribute( 'metaboxes', '\Base_Model' );
			$this->assertTrue( method_exists( $this->_model, 'add_metabox' ) );
			$stub = $this->getMockBuilder( 'Base_Model_Metabox' )
						 ->disableOriginalConstructor()
						 ->getMock();
						 
			$this->_model->add_metabox( 'foo', $stub );
			$this->assertEquals(
				array( 'foo' => $stub ),
				$this->getReflectionPropertyValue( $this->_model, 'metaboxes' )
			);
		}
		
		/**
		 * @covers Base_Model::add_metabox
		 */
		public function testMethodAddMetaboxFail()
		{
			$foo = new \StdClass;
			
			$this->assertTrue( method_exists( $this->_model, 'add_metabox') );
			$this->assertEquals(
				new \WP_Error(
					'fail',
					'Base_Model::add_metabox expects a Base_Model_Metabox object as the second parameter',
					$foo
				),
				$this->_model->add_metabox( 'foo', $foo )
			);
		}
		
		/**
		 * @covers Base_Model::get_metaboxes
		 */
		public function testMethodGetMetaboxes()
		{
			$this->assertClassHasAttribute( 'metaboxes', '\Base_Model' );
			$this->assertTrue( method_exists( $this->_model, 'get_metaboxes' ) );
			
			$stub = $this->getMockBuilder( '\Base_Model_Metabox' )
						 ->disableOriginalConstructor()
						 ->getMock();
			$this->setReflectionPropertyValue( $this->_model, 'metaboxes', array( 'foo' => $stub ) );
			
			$this->assertEquals( array( 'foo' => $stub ), $this->_model->get_metaboxes( 'bar', 'baz') );
		}
		
		/**
		 * @covers Base_Model::get_metaboxes
		 */
		public function testMethodGetmetaboxesEmpty()
		{
			$this->assertTrue( method_exists( $this->_model, 'get_metaboxes' ) );
			$this->assertFalse( $this->_model->get_metaboxes() );
		}
		
		/**
		 * @covers Base_Model::add_help_tab
		 */
		public function testMethodAddHelpTab()
		{
			$this->assertClassHasAttribute( 'help_tabs', '\Base_Model' );
			$this->assertTrue( method_exists( $this->_model, 'add_help_tab' ) );
			//set up our mock help tab object
			$stub = $this->getMockBuilder( '\Base_Model_Help_Tab' )
						 ->disableOriginalConstructor()
						 ->getMock();
			
			$this->_model->add_help_tab( 'foo', $stub );
			
			$this->assertEquals( 
				array( 'foo' => $stub ),
				$this->getReflectionPropertyValue( $this->_model, 'help_tabs' )
			);
		}
		
		/**
		 * Pass an object not of type Base_Model_Help_Tab. Test should fail.
		 * @covers Base_Model::add_help_tab
		 */
		public function testMethodAddHelpTabFail()
		{
			$this->assertTrue( method_exists( $this->_model, 'add_help_tab' ) );
			
			$tab = new \StdClass;
			
			$this->assertEquals(
				new \WP_Error(
					'invalid object type',
					'Base_Model::add_help_tab expects a Base_Model_Help_Tab object as the second parameter',
					$tab
				),
				$this->_model->add_help_tab( 'foo', $tab )
			);
		}
		
		/**
		 * @covers Base_Model::get_help_screen
		 * @depends testMethodAddHelpTab
		 */
		public function testMethodGetHelpScreen()
		{
			$this->assertTrue( method_exists( $this->_model, 'get_help_screen' ) );
			$stub = $this->getMockBuilder( 'Base_Model_Help_Tab' )
						 ->disableOriginalConstructor()
						 ->getMock();
			
			$this->_model->add_help_tab( 'foo', $stub );
			
			$this->assertEquals(
				array( 'foo' => $stub ),
				$this->_model->get_help_screen()
			);
		}
		
		/**
		 * @covers Base_Model::get_help_screen
		 * @depends testMethodGetHelpScreen
		 */
		public function testMethodGetHelpScreenError()
		{
			@$this->_model->get_help_screen( __FILE__, 'my-super-cool-text-domain' );
			$error = error_get_last();
			$this->assertEquals(
				'DEPRECATED: The function get_help_screen is deprecated. Please use get_help_tabs instead.',
				$error['message']
			);
		}
		
		/**
		 * @covers Base_Model::get_help_tabs
		 */
		public function testMethodGetHelpTabs()
		{
			$this->assertTrue( method_exists( $this->_model, 'get_help_tabs' ) );
			
			$this->setReflectionPropertyValue( $this->_model, 'help_tabs', array( 'foo' => 1 , 'bar' => 2 ) );
			
			$this->assertEquals( 
				array( 'foo' => 1, 'bar' => 2 ),
				$this->_model->get_help_tabs()
			);
		}
		
		/**
		 * @covers Base_Model::get_help_tabs
		 */
		public function testMethodGetHelpTabsEmpty()
		{
			$this->assertTrue( method_exists( $this->_model, 'get_help_tabs' ) );
			$this->assertFalse( $this->_model->get_help_tabs() );
		}
		
		/**
		 * @covers Base_Model::add_shortcode
		 */
		public function testMethodAddShortcode()
		{
			$this->assertClassHasAttribute( 'shortcodes', '\Base_Model' );
			$this->assertTrue( method_exists( $this->_model, 'add_shortcode' ) );
			
			$this->assertTrue( $this->_model->add_shortcode( 'foo', array( &$this, 'testMethodGetHelpTabs' ) ) );
		}
		
		/**
		 * @covers Base_Model::add_shortcode
		 */
		public function testMethodAddShortcodeFail()
		{
			$this->assertTrue( method_exists( $this->_model, 'add_shortcode' ) );
			
			$this->assertEquals(
				new \WP_Error(
					'not callable',
					'Base_Model::add_shortcode expects a valid callback.',
					'foocallback'
				),
				$this->_model->add_shortcode( 'fooshortcode', 'foocallback' )
			);	
		}
		
		/**
		 * @covers Base_Model::get_shortcodes
		 */
		public function testMethodGetShortcodes()
		{
			$this->assertTrue( method_exists( $this->_model, 'get_shortcodes' ) );
			$this->setReflectionPropertyValue(
				$this->_model,
				'shortcodes',
				array('fooshortcode' => array( &$this, 'testMethodAddShortcode' ) ) 
			);
			
			$this->assertEquals( array( 'fooshortcode' => array( &$this, 'testMethodAddShortcode' ) ), $this->_model->get_shortcodes() );
		}
		
		/**
		 * Test function when there are no shortcodes for this model.
		 * @covers Base_Model::get_shortcodes
		 * @depends testMethodGetShortcodes
		 */
		public function testMethodGetShortcodesEmpty()
		{
			$this->assertNull( $this->_model->get_shortcodes() );
		}
	}
}
