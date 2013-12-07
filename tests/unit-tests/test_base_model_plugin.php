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
			$args = array(
				'foo', 
				'1.0.1',
				__FILE__,
				dirname( __FILE__ ),
				dirname( __FILE__ ) . '/app',
				dirname( __FILE__ ) . '/base',
				'http://example.com',
				'bar'
			);
			
			$this->model = $this->getMockBuilder( '\Base_Model_Plugin' )
			                     ->setConstructorArgs( $args )
			                     ->getMockForAbstractClass();
		}

		public function tearDown()
		{
			unset( $this->model );
		}
		
		/**
		 * @covers Base_Model_Plugin::__construct
		 */
		public function testAttributeExistsSlug()
		{
			$this->assertClassHasAttribute( 'slug', '\Base_Model_Plugin' );
			$this->assertEquals( 'foo', $this->getReflectionPropertyValue( $this->model, 'slug' ) );
		}
		
		/**
		 * @covers Base_Model_Plugin::__construct
		 */
		public function testAttributeExistsVersion()
		{
			$this->assertClassHasAttribute( 'version', '\Base_Model_Plugin' );
			$this->assertEquals( '1.0.1', $this->getReflectionPropertyValue( $this->model, 'version' ) );
		}
		
		/**
		 * @covers Base_Model_Plugin::__construct
		 */
		public function testAttributeExistsPath()
		{
			$this->assertClassHasAttribute( 'path', '\Base_Model_Plugin' );
			$this->assertEquals( dirname( __FILE__ ) . '/' , $this->getReflectionPropertyValue( $this->model, 'path' ) );
		}
		
		/**
		 * @covers Base_Model_Plugin::__construct
		 */
		public function testAttributeExistsAppPath()
		{
			$this->assertClassHasAttribute( 'app_path', '\Base_Model_Plugin' );
			$this->assertEquals( dirname( __FILE__ ) . '/app/', $this->getReflectionPropertyValue( $this->model, 'app_path' ) );
		}
		
		/**
		 * @covers Base_Model_Plugin::__construct
		 */
		public function testAttributeExistsBasePath()
		{
			$this->assertClassHasAttribute( 'base_path', '\Base_Model_Plugin' );
			$this->assertEquals( dirname( __FILE__ ) . '/base/' , $this->getReflectionPropertyValue( $this->model, 'base_path' ) );
		}
		
		/**
		 * @covers Base_Model_Plugin::__construct
		 */
		public function testAttributeExistsMainPluginFile()
		{
			$this->assertClassHasAttribute( 'main_plugin_file', '\Base_Model_Plugin' );
			$this->assertEquals( __FILE__, $this->getReflectionPropertyValue( $this->model, 'main_plugin_file' ) );
		}
		
		/**
		 * @covers Base_Model_Plugin::__construct
		 */
		public function testAttributeExistsUri()
		{
			$this->assertClassHasAttribute( 'uri', '\Base_Model_Plugin' );
			$this->assertEquals( 'http://example.com/', $this->getReflectionPropertyValue( $this->model, 'uri' ) );
		}
		
		/**
		 * @covers Base_Model_Plugin::__construct
		 */
		public function testAttributeExistsTxtdomain()
		{
			$this->assertClassHasAttribute( 'txtdomain', '\Base_Model_Plugin' );
			$this->assertEquals( 'bar', $this->getReflectionPropertyValue( $this->model, 'txtdomain' ) );
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
			$this->assertTrue( method_exists( $this->model, 'get_slug' ) );
			$this->assertEquals( 'foo', $this->model->get_slug() );
		}

		/**
		 * @covers Base_Model_Plugin::get_version
		 */
		public function testMethodGetVersion()
		{
			$this->assertTrue( method_exists( $this->model, 'get_version' ) );
			$this->assertEquals( '1.0.1', $this->model->get_version() );
		}
	}
}
