<?php
namespace WPMVCB\Testing
{
	require_once( WPMVCB_SRC_DIR . '/models/base_model_plugin.php' );
	
	/**
	 * The test class for Base_Model_Plugin attributes.
	 *
	 * @package WPMVCBase_Testing\Unit_Tests
	 * @since WPMVCBase 0.1
	 * @internal
	 */
	class BaseControllerPluginPropertiesTest extends WPMVCB_Test_Case
	{
		public function setUp()
		{
			$this->_model = new \Base_Model_Plugin( 'foo', '1.0.1', __FILE__, dirname( __FILE__ ), 'http://example.com', 'bar' );
		}
		
		public function tearDown()
		{
			unset( $this->_model );
		}
		
		public function testAttributeExistsSlug()
		{
			$this->assertClassHasAttribute( 'slug', '\Base_Model_Plugin' );
		}
		
		public function testAttributeExistsVersion()
		{
			$this->assertClassHasAttribute( 'version', '\Base_Model_Plugin' );
		}
		
		public function testAttributeExistsPath()
		{
			$this->assertClassHasAttribute( 'path', '\Base_Model_Plugin' );
		}
		
		public function testAttributeExistsAppPath()
		{
			$this->assertClassHasAttribute( 'app_path', '\Base_Model_Plugin' );
		}
		
		public function testAttributeExistsAppControllersPath()
		{
			$this->assertClassHasAttribute( 'app_controllers_path', '\Base_Model_Plugin' );
		}
		
		public function testAttributeExistsAppModelsPath()
		{
			$this->assertClassHasAttribute( 'app_models_path', '\Base_Model_Plugin' );
		}
		
		public function testAttributeExistsAppViewsPath()
		{
			$this->assertClassHasAttribute( 'app_views_path', '\Base_Model_Plugin' );
		}
		
		public function testAttributeExistsBasePath()
		{
			$this->assertClassHasAttribute( 'base_path', '\Base_Model_Plugin' );
		}
		
		public function testAttributeExistsBaseControllersPath()
		{
			$this->assertClassHasAttribute( 'base_controllers_path', '\Base_Model_Plugin' );
		}
		
		public function testAttributeExistsBaseModelsPath()
		{
			$this->assertClassHasAttribute( 'base_models_path', '\Base_Model_Plugin' );
		}
		
		public function testAttributeExistsBaseViewsPath()
		{
			$this->assertClassHasAttribute( 'base_views_path', '\Base_Model_Plugin' );
		}
		
		public function testAttributeExistsMainPluginFile()
		{
			$this->assertClassHasAttribute( 'main_plugin_file', '\Base_Model_Plugin' );
		}
		
		public function testAttributeExistsUri()
		{
			$this->assertClassHasAttribute( 'uri', '\Base_Model_Plugin' );
		}
		
		public function testAttributeExistsJsUri()
		{
			$this->assertClassHasAttribute( 'js_uri', '\Base_Model_Plugin' );
		}
		
		public function testAttributeExistsCssUri()
		{
			$this->assertClassHasAttribute( 'css_uri', '\Base_Model_Plugin' );
		}
		
		public function testAttributeExistsTxtdomain()
		{
			$this->assertClassHasAttribute( 'txtdomain', '\Base_Model_Plugin' );
		}
		
		public function testAttributeExistsCpts()
		{
			$this->assertClassHasAttribute( 'cpts', '\Base_Model_Plugin' );
		}
		
		public function testAttributeExistsSettingsModel()
		{
			$this->assertClassHasAttribute( 'settings_model', '\Base_Model_Plugin' );
		}
		
		public function testAttributeExistsHelpTabs()
		{
			$this->assertClassHasAttribute( 'help_tabs', '\Base_Model_Plugin' );
		}
		
		public function testAttributeExistsNonceName()
		{
			$this->assertClassHasAttribute( 'nonce_name', '\Base_Model_Plugin' );
		}
		
		public function testAttributeExistsNonceAction()
		{
			$this->assertClassHasAttribute( 'nonce_action', '\Base_Model_Plugin' );
		}
		
		public function testAttributeExistsCss()
		{
			$this->assertClassHasAttribute( 'css', '\Base_Model_Plugin' );
		}
		
		public function testAttributeExistsAdminCss()
		{
			$this->assertClassHasAttribute( 'admin_css', '\Base_Model_Plugin' );
		}
		
		public function testAttributeExistsScripts()
		{
			$this->assertClassHasAttribute( 'scripts', '\Base_Model_Plugin' );
		}
		
		public function testAttributeExistsAdminScripts()
		{
			$this->assertClassHasAttribute( 'admin_scripts', '\Base_Model_Plugin' );
		}
		
		public function testAttributeExistsMetaboxes()
		{
			$this->assertClassHasAttribute( 'metaboxes', '\Base_Model_Plugin' );
		}
		
		/**
		 * @covers Base_Model_Plugin::get_slug
		 */
		public function testMethodGetSlug()
		{
			$this->assertTrue( method_exists( $this->_model, 'get_slug' ) );
			$this->assertEquals( 'foo', $this->_model->get_slug() );
		}
		
		/**
		 * @covers Base_Model_Plugin::get_version
		 */
		public function testMethodGetVersion()
		{
			$this->assertTrue( method_exists( $this->_model, 'get_version' ) );
			$this->assertEquals( '1.0.1', $this->_model->get_version() );
		}
		
		/**
		 * expectedException PHPUnit_Framework_Error
		 * expectedExceptionMessage DEPRECATED: The function main_plugin_file is deprecated. Please use get_main_plugin_file instead.
		 * @covers Base_Model_Plugin::main_plugin_file
		 */
		public function testMethodMainPluginFile()
		{
			$this->assertTrue( method_exists( $this->_model, 'main_plugin_file' ) );
			$this->assertEquals( __FILE__, $this->_model->main_plugin_file() );
		}
		
		/**
		 * @covers Base_Model_Plugin::get_main_plugin_file
		 */
		public function testMethodGetMainPluginFile()
		{
			$this->assertTrue( method_exists( $this->_model, 'get_main_plugin_file' ) );
			$this->assertEquals( __FILE__, $this->_model->get_main_plugin_file() );
		}
		
		/**
		 * @covers Base_Model_Plugin::get_path
		 */
		public function testMethodGetPath()
		{
			$this->assertTrue( method_exists( $this->_model, 'get_path' ) );
			$this->assertEquals( trailingslashit( dirname( __FILE__ ) ), $this->_model->get_path() );
		}
		
		/**
		 * @covers Base_Model_Plugin::get_app_path
		 */
		public function testMethodGetAppPath()
		{
			$this->assertTrue( method_exists( $this->_model, 'get_app_path' ) );
			$this->assertEquals( trailingslashit( dirname( __FILE__ ) ) . 'app/', $this->_model->get_app_path() );
		}
		
		/**
		 * @covers Base_Model_Plugin::get_app_controllers_path
		 */
		public function testMethodGetAppControllersPath()
		{
			$this->assertTrue( method_exists( $this->_model, 'get_app_controllers_path' ) );
			$this->assertEquals( trailingslashit( dirname( __FILE__ ) ) .'app/controllers/', $this->_model->get_app_controllers_path() ); 
		}
		
		/**
		 * @covers Base_Model_Plugin::get_app_models_path
		 */
		public function testMethodGetAppModelsPath()
		{
			$this->assertTrue( method_exists( $this->_model, 'get_app_models_path' ) );
			$this->assertEquals( trailingslashit( dirname( __FILE__ ) ) .'app/models/', $this->_model->get_app_models_path() );
		}
		
		/**
		 * @covers Base_Model_Plugin::get_app_views_path
		 */
		public function testMethodGetAppViewsPath()
		{
			$this->assertTrue( method_exists( $this->_model, 'get_app_views_path' ) );
			$this->assertEquals( trailingslashit( dirname( __FILE__ ) ) .'app/views/', $this->_model->get_app_views_path() );
		}
		
		/**
		 * @covers Base_Model_Plugin::get_base_path
		 */
		public function testMethodGetBasePath()
		{
			$this->assertTrue( method_exists( $this->_model, 'get_base_path' ) );
			$this->assertEquals( trailingslashit( dirname( dirname( dirname( __FILE__ ) ) ) ), $this->_model->get_base_path() );
		}
		
		/**
		 * @covers Base_Model_Plugin::get_base_controllers_path
		 */
		public function testMethodGetBaseControllersPath()
		{
			$this->assertTrue( method_exists( $this->_model, 'get_base_controllers_path' ) );
			$this->assertEquals( trailingslashit( dirname ( dirname( dirname( __FILE__ ) ) ) ) . 'controllers/', $this->_model->get_base_controllers_path() );
		}
		
		/**
		 * @covers Base_Model_Plugin::get_base_models_path
		 */
		public function testMethodGetBaseModelsPath()
		{
			$this->assertTrue( method_exists( $this->_model, 'get_base_models_path' ) );
			$this->assertEquals( trailingslashit( dirname( dirname( dirname( __FILE__ ) ) ) ) . 'models/', $this->_model->get_base_models_path() );
		}
		
		/**
		 * @covers Base_Model_Plugin::get_base_views_path
		 */
		public function testMethodGetBaseViewsPath()
		{
			$this->assertTrue( method_exists( $this->_model, 'get_base_views_path' ) );
			$this->assertEquals( trailingslashit( dirname( dirname( dirname( __FILE__ ) ) ) ) . 'views/', $this->_model->get_base_views_path() );
		}
		
		/**
		 * @covers Base_Model_Plugin::get_uri
		 */
		public function testMethodGetUri()
		{
			$this->assertTrue( method_exists( $this->_model, 'get_uri' ) );
			$this->assertEquals( 'http://example.com/', $this->_model->get_uri() );
		}
		
		/**
		 * @covers Base_Model_Plugin::get_textdomain
		 */
		public function testMethodGetTextdomain()
		{
			$this->assertTrue( method_exists( $this->_model, 'get_textdomain' ) );
			$this->assertEquals( 'bar', $this->_model->get_textdomain() );
		}
	}
}
?>