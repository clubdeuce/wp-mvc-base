<?php
namespace WPMVCB\Testing
{
	use \Base_Model_Metabox;
	
	/**
	 * The test controller for Base_Model_Metabox.
	 *
	 * @package             WPMVCBase_Testing\Unit_Tests
	 * @coversDefaultClass  Base_Model_Metabox
	 * @since               WPMVCBase 0.1
	 * @internal
	 */
	 
	class TestBaseModelMetabox extends WPMVCB_Test_Case
	{
		public function setUp()
		{
			parent::setUp();
			$this->metabox      = new Base_Model_Metabox( array(
				'id'            => 'my-super-cool-metabox',
				'title'         => 'My Super Cool Metabox',
				'callback'      => 'my_super_cool_callback',
				'post_types'    => array( 'my_super_cool_posttype' ),
				'context'       => 'normal',
				'priority'      => 'default',
				'callback_args' => array( 'foo' => 'bar' )
			) );
		}

		/**
		 * @depends testMethodAdd
		 * @covers  ::remove
		 */
		// public function testMethodRemove()
		// {
		// 	global $wp_meta_boxes;
			
		// 	$this->assertTrue( method_exists( $this->metabox, 'remove' ), 'Method does not exist' );
			
		// 	$this->metabox->add();
		// 	$this->assertMetaboxExists(
		// 		array(
		// 			'my-super-cool-metabox',
		// 			'My Super Cool Metabox',
		// 			'my_super_cool_callback',
		// 			'my_super_cool_posttype',
		// 			'normal',
		// 			'default',
		// 			array( 'foo' => 'bar' )
		// 		)
		// 	);
			
		// 	$this->metabox->remove();
			
		// 	$this->assertFalse( is_array(  $wp_meta_boxes['my_super_cool_posttype']['normal']['default']['my-super-cool-metabox'] ), 'Metabox not removed' );
		// }

		/**
		 * @covers ::get_id
		 */
		public function testMethodGetId()
		{
			$this->assertTrue( method_exists( $this->metabox, 'get_id' ), 'Method does not exist' );
			$this->assertEquals( 'my-super-cool-metabox', $this->metabox->get_id(), 'ID Incorrect' );
		}

		/**
		 * @covers ::get_title
		 */
		public function testMethodGetTitle()
		{
			$this->assertTrue( method_exists( $this->metabox, 'get_title' ), 'Method does not exist' );
			$this->assertEquals( 'My Super Cool Metabox', $this->metabox->get_title(), 'Title Incorrect' );
		}

		/**
		 * @covers ::get_callback
		 */
		public function testMethodGetCallback()
		{
			$this->assertTrue( method_exists( $this->metabox, 'get_callback' ), 'Method does not exist' );
			$this->assertEquals( 'my_super_cool_callback', $this->metabox->get_callback() );
		}

		/**
		 * @covers ::get_post_types
		 */
		public function testMethodGetPostTypes()
		{
			$this->assertTrue( method_exists( $this->metabox, 'get_post_types' ), 'Method does not exist' );
			$this->assertEquals( array( 'my_super_cool_posttype' ), $this->metabox->get_post_types() );
		}

		/**
		 * @covers ::get_context
		 */
		public function testMethodGetContext()
		{
			$this->assertTrue( method_exists( $this->metabox, 'get_context' ), 'Method does not exist' );
			$this->assertEquals( 'normal', $this->metabox->get_context() );
		}

		/**
		 * @covers ::get_priority
		 */
		public function testMethodGetPriority()
		{
			$this->assertTrue( method_exists( $this->metabox, 'get_priority' ), 'Method does not exist' );
			$this->assertEquals( 'default', $this->metabox->get_priority() );
		}

		/**
		 * @covers ::get_callback_args
		 */
		public function testMethodGetCallbackArgs()
		{
			$post = $this->factory->post->create();

			$this->assertTrue( method_exists( $this->metabox, 'get_callback_args' ), 'Method does not exist' );
			$this->assertEquals( array( 'foo' => 'bar' ), $this->metabox->get_callback_args( $post ) );
		}
		
		/**
		 * @depends testMethodGetId
		 * @covers  ::set_id
		 */
		public function testMethodSetId()
		{
			$this->assertTrue( method_exists( $this->metabox, 'set_id' ), 'Method does not exist' );
			$this->metabox->set_id( 'flibbertygibbet' );
			$this->assertEquals( 'flibbertygibbet', $this->metabox->get_id() );
		}

		/**
		 * @depends testMethodGetTitle
		 * @covers  ::set_title
		 */
		public function testMethodSetTitle()
		{
			$this->assertTrue( method_exists( $this->metabox, 'set_title' ), 'Method does not exist' );
			$this->metabox->set_title( 'flibbertygibbet' );
			$this->assertEquals( 'flibbertygibbet', $this->metabox->get_title() );
		}

		/**
		 * @depends testMethodGetCallback
		 * @covers  ::set_callback
		 */
		public function testMethodSetCallback()
		{
			$this->assertTrue( method_exists( $this->metabox, 'set_callback' ), 'Method does not exist' );
			$this->metabox->set_callback( 'flibbertygibbet' );
			$this->assertEquals( 'flibbertygibbet', $this->metabox->get_callback() );
		}

		/**
		 * @depends testMethodGetPostTypes
		 * @covers  ::set_post_type
		 */
		public function testMethodSetPostTypes()
		{
			$this->assertTrue( method_exists( $this->metabox, 'set_post_type' ), 'Method does not exist' );
			$this->metabox->set_post_type( array( 'flibbertygibbet' ) );
			$this->assertEquals( array( 'flibbertygibbet' ), $this->metabox->get_post_types() );
		}

		/**
		 * @depends testMethodGetContext
		 * @covers  ::set_context
		 */
		public function testMethodSetContext()
		{
			$this->assertTrue( method_exists( $this->metabox, 'set_context' ), 'Method does not exist' );
			$this->metabox->set_context( 'side' );
			$this->assertEquals( 'side', $this->metabox->get_context() );
		}

		/**
		 * @depends testMethodGetPriority
		 * @covers  ::set_priority
		 */
		public function testMethodSetPriority()
		{
			$this->assertTrue( method_exists( $this->metabox, 'set_priority' ), 'Method does not exist' );
			$this->metabox->set_priority( 'low' );
			$this->assertEquals( 'low', $this->metabox->get_priority() );
		}

		/**
		 * @depends testMethodGetCallbackArgs
		 * @covers  ::set_callback_args
		 */
		public function testMethodSetCallbackArgs()
		{
			$post = $this->factory->post->create();

			$this->assertTrue( method_exists( $this->metabox, 'set_callback_args' ), 'Method does not exist' );
			$this->metabox->set_callback_args( array( 'flibbertygibbet' => 'mtzlplck' ) );
			$this->assertEquals( array( 'flibbertygibbet' => 'mtzlplck' ), $this->metabox->get_callback_args( $post ) );
		}
		
		/**
		 * Test faulty metabox context assignment.
		 *
		 * This function tests the metabox object's setting the context to 'normal' when
		 * passed a value other than 'normal', 'advanced', or 'side'.
		 *
		 * @depends testMethodGetContext
		 * @covers  ::__construct
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
		 * @covers  ::__construct
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
