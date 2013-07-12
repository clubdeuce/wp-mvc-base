<?php
namespace WPMVCB\Testing
{
	require_once( WPMVCB_TEST_DIR . '/includes/test_stub_model_settings.php' );
	
	class testBaseModelSettings extends \WP_UnitTestCase
	{
		public function setUp()
		{
			$this->_settings_model = new TestStubModelSettings( 'http://example.com', 'foopath', 'footxtdomain');
		}
		
		public function testPropertyOptionsExists()
		{
			$this->assertClassHasAttribute( 'options', '\Base_Model_Settings' );
		}
		
		public function testPropertyPagesExists()
		{
			$this->assertClassHasAttribute( 'pages', '\Base_Model_Settings' );
		}
		
		public function testPropertySettingsSectionsExists()
		{
			$this->assertClassHasAttribute( 'settings_sections', '\Base_Model_Settings' );
		}
		
		public function testPropertySettingsFieldsExists()
		{
			$this->assertClassHasAttribute( 'settings_fields', '\Base_Model_Settings' );
		}
		
		public function testPropertySettingsExists()
		{
			$this->assertClassHasAttribute( 'settings', '\Base_Model_Settings' );
		}
		
		public function testMethodGetOptionsExists()
		{
			$this->assertTrue( method_exists( '\Base_Model_Settings', 'get_options' ) );
		}
		
		public function testMethodGetPagesExists()
		{
			$this->assertTrue( method_exists( '\Base_Model_Settings', 'get_pages' ) );
		}
		
		public function testMethodGetSettingsSectionsExists()
		{
			$this->assertTrue( method_exists( '\Base_Model_Settings', 'get_settings_sections' ) );
		}
		
		public function testMethodGetSettingsFieldsExists()
		{
			$this->assertTrue( method_exists( '\Base_Model_Settings', 'get_settings_fields' ) );
		}
		
		public function testMethodGetSettingsExists()
		{
			$this->assertTrue( method_exists( '\Base_Model_Settings', 'get_settings' ) );
		}
		
		/**
		 * @depends testMethodGetOptionsExists
		 */
		public function testMethodGetOptions()
		{
			$this->assertEquals(
				array(
					'test_options'	=> array(
						'option_group'	=> 'my_option_group_name',
						'option_name'	=> 'my_option_name',
						'callback'		=> array( $this->_settings_model, 'sanitize_callback' )
					)
				),
				$this->_settings_model->get_options()
			);
		}
		
		/**
		 * @depends testMethodGetPagesExists
		 */
		public function testMethodGetPages()
		{
			$pages = $this->_settings_model->get_pages();
			$this->assertTrue( is_array( $pages ), '$Pages is not an array' );
			$this->assertTrue( 3 === count( $pages ), 'Page count does not match' );
		}
	}
}
?>