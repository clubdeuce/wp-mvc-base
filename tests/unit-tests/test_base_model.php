<?php
namespace WPMVCB\Testing
{
	require_once( WPMVCB_SRC_DIR . '/models/base_model.php' );
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
		
		public function testMethodGetCss()
		{
			$this->assertTrue( method_exists( $this->_model, 'get_css' ) );
			$this->setReflectionPropertyValue( $this->_model, 'css', array( 'foo_css' => array( 'handle' => 'bar_css' ) ) );
			
			$this->assertEquals(
				array( 'foo_css' => array( 'handle' => 'bar_css' ) ),
				$this->_model->get_css( 'http://my-super-cool-site' )
			);
		}
		
		public function testMethodGetAdminCssExists()
		{
			$this->assertTrue( method_exists( $this->_model, 'get_admin_css' ) );
		}
		
		/**
		 * @depends testMethodGetAdminCssExists
		 */
		public function testMethodGetAdminCss()
		{
			$this->assertTrue( method_exists( $this->_model, 'get_admin_css' ) );
			$this->setReflectionPropertyValue( $this->_model, 'admin_css', array( 'foo_admin_css' => array( 'handle' => 'bar_admin_css' ) ) );
			$this->assertEquals(
				array( 'foo_admin_css' => array( 'handle' => 'bar_admin_css' ) ),
				$this->_model->get_admin_css( 'http://my-super-cool-site' )
			);
		}
		
		public function testMethodGetScripts()
		{
			$this->assertTrue( method_exists( $this->_model, 'get_scripts' ) );
			global $post;
			
			$this->setReflectionPropertyValue( $this->_model, 'scripts', array ( 'foo_scripts' => 'bar_scripts' ) );
			$this->assertEquals(
				array ( 'foo_scripts' => 'bar_scripts' ),
				$this->_model->get_scripts( $post, 'my-super-cool-text-domain', 'http://my-super-cool-site' )
			);
		}
		
		public function testMethodGetAdminScripts()
		{
			$this->assertTrue( method_exists( $this->_model, 'get_admin_scripts' ) );
			
			global $post;
			$this->setReflectionPropertyValue( $this->_model, 'admin_scripts', array( 'foo_admin_scripts' => 'bar_admin_scripts' ) );
			$this->assertEquals(
				array( 'foo_admin_scripts' => 'bar_admin_scripts' ),
				$this->_model->get_admin_scripts( $post, 'http://my-super-cool-site' )
			);
		}
		
		public function testMethodAddMetaboxExists()
		{
			$this->assertTrue( method_exists( $this->_model, 'add_metabox' ) );
		}
		
		/**
		 * @depends testMethodAddMetaboxExists
		 */
		public function testMethodAddMetabox()
		{	
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
		 * @depends testMethodAddMetaboxExists
		 */
		public function testMethodAddMetaboxFail()
		{
			$this->setExpectedException( 'PHPUnit_Framework_Error', 'add_metabox expects a Base_Model_Metabox object as the second parameter' );
			$this->_model->add_metabox( 'foo', 'bar' );
		}
		
		public function testMethodGetMetaboxes()
		{
			$this->assertTrue( method_exists( $this->_model, 'get_metaboxes' ) );
			
			$stub = $this->getMockBuilder( '\Base_Model_Metabox' )
						 ->disableOriginalConstructor()
						 ->getMock();
			$this->setReflectionPropertyValue( $this->_model, 'metaboxes', array( 'foo' => $stub ) );
			
			$this->assertEquals( array( 'foo' => $stub ), $this->_model->get_metaboxes( 'bar', 'baz') );
		}
		
		public function testMethodAddHelpTabExists()
		{
			$this->assertTrue( method_exists( $this->_model, 'add_help_tab' ) );
		}
		
		/**
		 * @depends testMethodAddHelpTabExists
		 */
		public function testMethodAddHelpTab()
		{	
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
		 * @depends testMethodAddHelpTabExists
		 */
		public function testMethodAddHelpTabFail()
		{
			$this->setExpectedException( 'PHPUnit_Framework_Error', 'add_help_tab expects a Base_Model_Help_Tab object as the second parameter' );
			$this->_model->add_help_tab( 'foo', 'bar' );
		}
		
		public function testMethodGetHelpScreenExists()
		{
			$this->assertTrue( method_exists( $this->_model, 'get_help_screen' ) );
		}
		
		/**
		 * @depends testMethodGetHelpScreenExists
		 */
		public function testMethodGetHelpScreenError()
		{
			$this->setExpectedException( 
				'PHPUnit_Framework_Error',
				'DEPRECATED: The function get_help_screen is deprecated. Please use get_help_tabs instead.'
			);
			$this->_model->get_help_screen( __FILE__, 'my-super-cool-text-domain' );
		}
		
		/**
		 * @depends testMethodGetHelpScreenExists
		 */
		public function testMethodGetHelpScreen()
		{
			$stub = $this->getMockBuilder( 'Base_Model_Help_Tab' )
						 ->disableOriginalConstructor()
						 ->getMock();
			
			$this->_model->add_help_tab( 'foo', $stub );
			
			$this->assertEquals(
				array( 'foo' => $stub ),
				@$this->_model->get_help_screen()
			);
		}
		
		public function testMethodGetHelpTabs()
		{
			$this->assertTrue( method_exists( $this->_model, 'get_help_tabs' ) );
			
			$this->setReflectionPropertyValue( $this->_model, 'help_tabs', array( 'foo' => 1 , 'bar' => 2 ) );
			
			$this->assertEquals( 
				array( 'foo' => 1, 'bar' => 2 ),
				$this->_model->get_help_tabs()
			);
		}
		
		public function testMethodAddShortcode()
		{
			$this->assertTrue( method_exists( $this->_model, 'add_shortcode' ) );
			$this->_model->add_shortcode( 'fooshortcode', 'foocallback' );
			
			$this->assertEquals(
				array( 'fooshortcode' => 'foocallback' ),
				$this->getReflectionPropertyValue( $this->_model, 'shortcodes' )
			);
		}
		
		/**
		 * @depends testMethodAddShortcode
		 */
		public function testMethodGetShortcodes()
		{
			$this->assertTrue( method_exists( $this->_model, 'get_shortcodes' ) );
			$this->_model->add_shortcode( 'fooshortcode', 'foocallback' );
			$this->assertEquals( array( 'fooshortcode' => 'foocallback' ), $this->_model->get_shortcodes() );
		}
		
		/**
		 * Test function when there are no shortcodes attached to this cpt.
		 * @depends testMethodAddShortcode
		 */
		public function testMethodGetShortcodesEmpty()
		{
			$this->assertNull( $this->_model->get_shortcodes() );
		}
	}
}
?>