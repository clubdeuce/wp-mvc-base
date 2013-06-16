<?php
namespace WPMVCBase\Testing
{
	require_once( dirname( __FILE__ ) . '../../../models/base_model_cpt.php' );
	
	/**
	 * The Test Stub CPT Model
	 *
	 * @package pkgtoken
	 * @since WP MVC Base Testing 0.1
	 */
	class Test_Stub_Base_Model_CPT extends \Base_Model_CPT
	{
		protected $slug = 'my-super-cool-cpt';
		protected $metakey = '_my-super-cool-metakey';
		protected $shortcodes = array(
			'my-super-cool-shortcode' => 'my-super-cool-callback'
		);
		
		public function save( $postdata )
		{
			//dummy implementation of abstract function
		}
	}
	
	/**
	 * The test controller for Base_Model_CPT
	 *
	 * @package WPMVCBase_Testing\Unit_Tests
	 * @since WPMVCBase 0.1
	 * @internal
	 */
	 
	class Test_Base_Model_CPT extends \WP_UnitTestCase
	{
		private $_cpt;
		
		public function SetUp()
		{
			$this->_cpt = new Test_Stub_Base_Model_CPT( 'http://example.com', 'my-super-cool-text-domain' );
		}
		
		public function test_get_slug()
		{
			$this->assertEquals( 'my-super-cool-cpt', $this->_cpt->get_slug() );
		}
		
		public function test_get_metakey()
		{
			$this->assertEquals( '_my-super-cool-metakey', $this->_cpt->get_metakey() );
		}
		
		public function test_get_shortcodes()
		{
			$this->assertEquals( array( 'my-super-cool-shortcode' => 'my-super-cool-callback' ), $this->_cpt->get_shortcodes() );
		}
	}
}
?>