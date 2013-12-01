<?php
namespace WPMVCB\Testing
{
	require_once( WPMVCB_SRC_DIR . '/helpers/class-base-helpers.php' );
	require_once( WPMVCB_SRC_DIR . '/models/class-base-model-plugin.php' );

	/**
	 * The test class for Base_Model_Plugin attributes.
	 *
	 * @package WPMVCBase_Testing\Unit_Tests
	 * @since WPMVCBase 0.1
	 * @internal
	 */
	class testBaseModelPlugin extends WPMVCB_Test_Case
	{
		public function setUp()
		{
			$this->_model = new \Base_Model_Plugin(
				'foo', 
				'1.0.1',
				__FILE__,
				dirname( __FILE__ ),
				dirname( __FILE__ ) . '/app',
				dirname( __FILE__ ) . '/base',
				'http://example.com',
				'bar'
			);
		}

		public function tearDown()
		{
			unset( $this->_model );
		}
		
		/**
		 * @covers Base_Model_Plugin::__construct
		 */
		public function testAttributeExistsSlug()
		{
			$this->assertClassHasAttribute( 'slug', '\Base_Model_Plugin' );
			$this->assertEquals( 'foo', $this->getReflectionPropertyValue( $this->_model, 'slug' ) );
		}
		
		/**
		 * @covers Base_Model_Plugin::__construct
		 */
		public function testAttributeExistsVersion()
		{
			$this->assertClassHasAttribute( 'version', '\Base_Model_Plugin' );
			$this->assertEquals( '1.0.1', $this->getReflectionPropertyValue( $this->_model, 'version' ) );
		}
		
		/**
		 * @covers Base_Model_Plugin::__construct
		 */
		public function testAttributeExistsPath()
		{
			$this->assertClassHasAttribute( '_path', '\Base_Model_Plugin' );
			$this->assertEquals( dirname( __FILE__ ) . '/' , $this->getReflectionPropertyValue( $this->_model, '_path' ) );
		}
		
		/**
		 * @covers Base_Model_Plugin::__construct
		 */
		public function testAttributeExistsAppPath()
		{
			$this->assertClassHasAttribute( '_app_path', '\Base_Model_Plugin' );
			$this->assertEquals( dirname( __FILE__ ) . '/app/', $this->getReflectionPropertyValue( $this->_model, '_app_path' ) );
		}
		
		/**
		 * @covers Base_Model_Plugin::__construct
		 */
		public function testAttributeExistsBasePath()
		{
			$this->assertClassHasAttribute( '_base_path', '\Base_Model_Plugin' );
			$this->assertEquals( dirname( __FILE__ ) . '/base/' , $this->getReflectionPropertyValue( $this->_model, '_base_path' ) );
		}
		
		/**
		 * @covers Base_Model_Plugin::__construct
		 */
		public function testAttributeExistsMainPluginFile()
		{
			$this->assertClassHasAttribute( '_main_plugin_file', '\Base_Model_Plugin' );
			$this->assertEquals( __FILE__, $this->getReflectionPropertyValue( $this->_model, '_main_plugin_file' ) );
		}
		
		/**
		 * @covers Base_Model_Plugin::__construct
		 */
		public function testAttributeExistsUri()
		{
			$this->assertClassHasAttribute( '_uri', '\Base_Model_Plugin' );
			$this->assertEquals( 'http://example.com/', $this->getReflectionPropertyValue( $this->_model, '_uri' ) );
		}
		
		/**
		 * @covers Base_Model_Plugin::__construct
		 */
		public function testAttributeExistsTxtdomain()
		{
			$this->assertClassHasAttribute( '_txtdomain', '\Base_Model_Plugin' );
			$this->assertEquals( 'bar', $this->getReflectionPropertyValue( $this->_model, '_txtdomain' ) );
		}

		public function testAttributeExistsHelpTabs()
		{
			$this->assertClassHasAttribute( 'help_tabs', '\Base_Model_Plugin' );
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
			$this->assertEquals(dirname( __FILE__ ) .'/app/models/', $this->_model->get_app_models_path() );
		}

		/**
		 * @covers Base_Model_Plugin::get_app_views_path
		 */
		public function testMethodGetAppViewsPath()
		{
			$this->assertTrue( method_exists( $this->_model, 'get_app_views_path' ) );
			$this->assertEquals( dirname( __FILE__ ) .'/app/views/', $this->_model->get_app_views_path() );
		}

		/**
		 * @covers Base_Model_Plugin::get_base_path
		 */
		public function testMethodGetBasePath()
		{
			$this->assertTrue( method_exists( $this->_model, 'get_base_path' ) );
			$this->assertEquals( dirname( __FILE__ ) . '/base/', $this->_model->get_base_path() );
		}

		/**
		 * @covers Base_Model_Plugin::get_base_controllers_path
		 */
		public function testMethodGetBaseControllersPath()
		{
			$this->assertTrue( method_exists( $this->_model, 'get_base_controllers_path' ) );
			$this->assertEquals( dirname( __FILE__ ) . '/base/controllers/', $this->_model->get_base_controllers_path() );
		}

		/**
		 * @covers Base_Model_Plugin::get_base_models_path
		 */
		public function testMethodGetBaseModelsPath()
		{
			$this->assertTrue( method_exists( $this->_model, 'get_base_models_path' ) );
			$this->assertEquals( dirname( __FILE__ ) . '/base/models/', $this->_model->get_base_models_path() );
		}

		/**
		 * @covers Base_Model_Plugin::get_base_views_path
		 */
		public function testMethodGetBaseViewsPath()
		{
			$this->assertTrue( method_exists( $this->_model, 'get_base_views_path' ) );
			$this->assertEquals( dirname( __FILE__ ) . '/base/views/', $this->_model->get_base_views_path() );
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
