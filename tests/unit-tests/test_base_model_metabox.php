<?php
namespace WPMVCBase\Testing
{
	require_once( dirname( __FILE__ ) . '../../../models/base_model_metabox.php' );
	/**
	 * The test controller for Base_Model_Metabox.
	 *
	 * @package WPMVCBase_Testing\Unit_Tests
	 * @since WPMVCBase 0.1
	 * @internal
	 */
	 
	class Test_Base_Model_Metabox extends \WP_UnitTestCase
	{
		public function SetUp()
		{
			$this->_metabox = new \Base_Model_Metabox(
				'my-super-cool-metabox',
				'My Super Cool Metabox',
				'my_super_cool_callback',
				'my_super_cool_posttype',
				'normal',
				'default',
				array( 'foo' => 'bar' )
			);
		}
		
		public function test_get_id()
		{
			$this->assertEquals( 'my-super-cool-metabox', $this->_metabox->get_id() );
		}
		
		public function test_get_title()
		{
			$this->assertEquals( 'My Super Cool Metabox', $this->_metabox->get_title() );
		}
		
		public function test_get_callback()
		{
			$this->assertEquals( 'my_super_cool_callback', $this->_metabox->get_callback() );
		}
		
		public function test_get_post_type()
		{
			$this->assertEquals( 'my_super_cool_posttype', $this->_metabox->get_post_type() );
		}
		
		public function test_get_context()
		{
			$this->assertEquals( 'normal', $this->_metabox->get_context() );
		}
		
		public function test_get_priority()
		{
			$this->assertEquals( 'default', $this->_metabox->get_priority() );
		}
		
		public function test_get_callback_args()
		{
			$this->assertEquals( array( 'foo' => 'bar' ), $this->_metabox->get_callback_args() );
		}
		
		/**
		 * Test faulty metabox context assignment.
		 *
		 * This function tests the metabox object's setting the context to 'normal' when
		 * passed a value other than 'normal', 'advanced', or 'side'.
		 *
		 * @since 0.1
		 */
		public function test_invalid_context()
		{
			$metabox = new \Base_Model_Metabox(
				'my-super-cool-metabox',
				'My Super Cool Metabox',
				'my_super_cool_callback',
				'my_super_cool_posttype',
				'flibbertygibbet',
				'default',
				array( 'foo' => 'bar' )
			);
			
			$this->assertEquals( 'normal', $metabox->get_context() );
		}
		
		/**
		 * Test faulty metabox priority assignment.
		 *
		 * This function tests the metabox object's setting the priority to 'default' when
		 * passed a value other than 'high', 'core', 'default', or 'low'.
		 *
		 * @since 0.1
		 */
		public function test_invalid_priority()
		{
			$metabox = new \Base_Model_Metabox(
				'my-super-cool-metabox',
				'My Super Cool Metabox',
				'my_super_cool_callback',
				'my_super_cool_posttype',
				'normal',
				'flibbertygibbet',
				array( 'foo' => 'bar' )
			);
			
			$this->assertEquals( 'default', $metabox->get_priority() );
		}
	}
}
?>