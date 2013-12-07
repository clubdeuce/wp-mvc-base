<?php
namespace WPMVCB\Testing
{
	require_once( WPMVCB_SRC_DIR . '/models/class-base-model-metabox.php' );
	
	/**
	 * The test controller for Base_Model_Metabox.
	 *
	 * @package WPMVCBase_Testing\Unit_Tests
	 * @since WPMVCBase 0.1
	 * @internal
	 */
	 
	class TestBaseModelMetabox extends WPMVCB_Test_Case
	{
		public function SetUp()
		{
			parent::setUp();
			$this->metabox = new \Base_Model_Metabox(
				'my-super-cool-metabox',
				'My Super Cool Metabox',
				'my_super_cool_callback',
				array( 'my_super_cool_posttype' ),
				'normal',
				'default',
				array( 'foo' => 'bar' )
			);
		}
		
		public function testMethodAdd()
		{
			$this->assertTrue( method_exists( $this->metabox, 'add' ), 'Method does not exist' );
			$this->metabox->add();
			
			$this->assertMetaboxExists(
				array(
					'my-super-cool-metabox',
					'My Super Cool Metabox',
					'my_super_cool_callback',
					'my_super_cool_posttype',
					'normal',
					'default',
					array( 'foo' => 'bar' )
				)
			);
		}

		/**
		 * @depends testMethodAdd
		 */
		public function testMethodRemove()
		{
			global $wp_meta_boxes;
			
			$this->assertTrue( method_exists( $this->metabox, 'remove' ), 'Method does not exist' );
			
			$this->metabox->add();
			$this->assertMetaboxExists(
				array(
					'my-super-cool-metabox',
					'My Super Cool Metabox',
					'my_super_cool_callback',
					'my_super_cool_posttype',
					'normal',
					'default',
					array( 'foo' => 'bar' )
				)
			);
			
			$this->metabox->remove();
			
			$this->assertFalse( is_array(  $wp_meta_boxes['my_super_cool_posttype']['normal']['default']['my-super-cool-metabox'] ), 'Metabox not removed' );
		}

		
		public function testMethodGetId()
		{
			$this->assertTrue( method_exists( $this->metabox, 'get_id' ), 'Method does not exist' );
			$this->assertEquals( 'my-super-cool-metabox', $this->metabox->get_id(), 'ID Incorrect' );
		}
		
		public function testMethodGetTitle()
		{
			$this->assertTrue( method_exists( $this->metabox, 'get_title' ), 'Method does not exist' );
			$this->assertEquals( 'My Super Cool Metabox', $this->metabox->get_title(), 'Title Incorrect' );
		}
		
		public function testMethodGetCallback()
		{
			$this->assertTrue( method_exists( $this->metabox, 'get_callback' ), 'Method does not exist' );
			$this->assertEquals( 'my_super_cool_callback', $this->metabox->get_callback() );
		}
		
		public function testMethodGetPostTypes()
		{
			$this->assertTrue( method_exists( $this->metabox, 'get_post_types' ), 'Method does not exist' );
			$this->assertEquals( array( 'my_super_cool_posttype' ), $this->metabox->get_post_types() );
		}
		
		public function testMethodGetContext()
		{
			$this->assertTrue( method_exists( $this->metabox, 'get_context' ), 'Method does not exist' );
			$this->assertEquals( 'normal', $this->metabox->get_context() );
		}
		
		public function testMethodGetPriority()
		{
			$this->assertTrue( method_exists( $this->metabox, 'get_priority' ), 'Method does not exist' );
			$this->assertEquals( 'default', $this->metabox->get_priority() );
		}
		
		public function testMethodGetCallbackArgs()
		{
			$this->assertTrue( method_exists( $this->metabox, 'get_callback_args' ), 'Method does not exist' );
			$this->assertEquals( array( 'foo' => 'bar' ), $this->metabox->get_callback_args() );
		}
		
		/**
		 * @depends testMethodGetId
		 */
		public function testMethodSetId()
		{
			$this->assertTrue( method_exists( $this->metabox, 'set_id' ), 'Method does not exist' );
			$this->metabox->set_id( 'flibbertygibbet' );
			$this->assertEquals( 'flibbertygibbet', $this->metabox->get_id() );
		}
		
		/**
		 * @depends testMethodGetTitle
		 */
		public function testMethodSetTitle()
		{
			$this->assertTrue( method_exists( $this->metabox, 'set_title' ), 'Method does not exist' );
			$this->metabox->set_title( 'flibbertygibbet' );
			$this->assertEquals( 'flibbertygibbet', $this->metabox->get_title() );
		}
		
		/**
		 * @depends testMethodGetCallback
		 */
		public function testMethodSetCallback()
		{
			$this->assertTrue( method_exists( $this->metabox, 'set_callback' ), 'Method does not exist' );
			$this->metabox->set_callback( 'flibbertygibbet' );
			$this->assertEquals( 'flibbertygibbet', $this->metabox->get_callback() );
		}
		
		/**
		 * @depends testMethodGetPostTypes
		 */
		public function testMethodSetPostTypes()
		{
			$this->assertTrue( method_exists( $this->metabox, 'set_post_type' ), 'Method does not exist' );
			$this->metabox->set_post_type( array( 'flibbertygibbet' ) );
			$this->assertEquals( array( 'flibbertygibbet' ), $this->metabox->get_post_types() );
		}
		
		/**
		 * @depends testMethodGetContext
		 */
		public function testMethodSetContext()
		{
			$this->assertTrue( method_exists( $this->metabox, 'set_context' ), 'Method does not exist' );
			$this->metabox->set_context( 'side' );
			$this->assertEquals( 'side', $this->metabox->get_context() );
		}
		
		/**
		 * @depends testMethodGetPriority
		 */
		public function testMethodSetPriority()
		{
			$this->assertTrue( method_exists( $this->metabox, 'set_priority' ), 'Method does not exist' );
			$this->metabox->set_priority( 'low' );
			$this->assertEquals( 'low', $this->metabox->get_priority() );
		}
		
		/**
		 * @depends testMethodGetCallbackArgs
		 */
		public function testMethodSetCallbackArgs()
		{
			$this->assertTrue( method_exists( $this->metabox, 'set_callback_args' ), 'Method does not exist' );
			$this->metabox->set_callback_args( array( 'flibbertygibbet' => 'mtzlplck' ) );
			$this->assertEquals( array( 'flibbertygibbet' => 'mtzlplck' ), $this->metabox->get_callback_args() );
		}
		
		/**
		 * Test faulty metabox context assignment.
		 *
		 * This function tests the metabox object's setting the context to 'normal' when
		 * passed a value other than 'normal', 'advanced', or 'side'.
		 *
		 * @depends testMethodGetContext
		 * @since 0.1
		 */
		public function testInvalidContext()
		{
			$metabox = new \Base_Model_Metabox(
				'my-super-cool-metabox',
				'My Super Cool Metabox',
				'my_super_cool_callback',
				array( 'my_super_cool_posttype' ),
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
		 * @depends testMethodGetPriority
		 * @since 0.1
		 */
		public function testInvalidPriority()
		{
			$metabox = new \Base_Model_Metabox(
				'my-super-cool-metabox',
				'My Super Cool Metabox',
				'my_super_cool_callback',
				array( 'my_super_cool_posttype' ),
				'normal',
				'flibbertygibbet',
				array( 'foo' => 'bar' )
			);
			
			$this->assertEquals( 'default', $metabox->get_priority() );
		}
	}
}
?>