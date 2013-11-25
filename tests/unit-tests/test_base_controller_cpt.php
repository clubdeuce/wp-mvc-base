<?php
namespace WPMVCB\Testing
{
	require_once( WPMVCB_SRC_DIR . '/controllers/class-base-controller.php' );
	require_once( WPMVCB_SRC_DIR . '/controllers/class-base-controller-cpt.php' );

	/**
	 * The test controller for Base_Controller_Plugin.
	 *
	 * @package WPMVCBase_Testing\Unit_Tests
	 * @covers Base_Controller_CPT
	 * @since WPMVCBase 0.1
	 * @internal
	 */
	class TestBaseControllerCpt extends WPMVCB_Test_Case
	{
		public function setUp()
		{
			parent::setUp();
			$this->_controller = new \Base_Controller_CPT( $cpt_model );
		}

		public function tearDown()
		{
			//remove actions set up by these tests
			remove_action( 'the_post', 'foo' );
			remove_action( 'save_post', 'bar' );
			remove_action( 'delete_post', 'baz' );
			remove_action( 'post_updated_messages', array( $cpt_model, 'get_post_updated_messages' ) );
			unset( $this->_controller );
		}

		private function _createStubCptModel()
		{
			// Create stub for cpt_model
			$cpt_model = $this->getMockBuilder( '\Base_Model_CPT' )
						 ->disableOriginalConstructor()
						 ->setMethods( array( 'get_slug', 'get_args', 'get_post_updated_messages', 'get_metaboxes' ) )
						 ->getMock();

			return $cpt_model;
		}

		public function testPropertyCptModelsExists()
		{
			$this->assertClassHasAttribute( '_cpt_models', '\Base_Controller_CPT' );
		}

		/**
		 * @covers Base_Controller_CPT::__construct
		 */
		public function testActionExistsAdminEnqueueScripts()
		{
			$this->assertFalse( false === has_action( 'admin_enqueue_scripts', array( $this->_controller, 'admin_enqueue_scripts' ) ) );
		}

		/**
		 * @covers Base_Controller_CPT::__construct
		 */
		public function testActionExistsAddMetaBoxes()
		{
			$this->assertEquals( true, has_action( 'add_meta_boxes', array( &$this->_controller, 'add_meta_boxes' ) ) );
		}

		public function testMethodAddModelExists()
		{
			$this->assertTrue( method_exists( $this->_controller, 'add_model' ) );
		}

		/**
		 * @covers Base_Controller_CPT::add_model
		 * @depends testMethodAddModelExists
		 */
		public function testMethodAddModel()
		{
			$cpt_model = $this->_createStubCptModel();

			//set up stub function get_slug method
			$cpt_model->expects( $this->any() )
			          ->method( 'get_slug' )
			          ->will( $this->returnValue( 'fooslug' ) );

			$expected = array( 'fooslug' => $cpt_model );

			$this->_controller->add_model( $cpt_model );
			$this->assertEquals( $expected, $this->getReflectionPropertyValue( $this->_controller, '_cpt_models' ) );
		}

		/**
		 * @covers Base_Controller_CPT::add_model
		 * @depends testMethodAddModelExists
		 */
		public function testMethodAddModelFail()
		{
			$this->setExpectedException( 'PHPUnit_Framework_Error', 'add_model expects an object of type Base_Model_CPT' );
			$this->_controller->add_model( 'foo' );
		}

		/**
		 * @covers Base_Controller_CPT::__construct
		 */
		public function testActionInitRegisterExists()
		{
			$this->assertTrue( method_exists( $this->_controller, 'register' ), __( 'Method does not exist', 'wmvcb' ) );
			$this->assertFalse( false === has_action( 'init', array( $this->_controller, 'register' ) ) );
		}

		/**
		 * @covers Base_Controller_CPT::add_model
		 * @depends testMethodAddModel
		 */
		public function testActionThePostExists()
		{
			$this->_controller->add_model( $this->_createStubCptModel(), 'foo', 'bar', 'baz' );
			$this->assertFalse( false === has_action( 'the_post', 'foo' ), __( 'Action the_post callback not registered', 'wpmvcb' ) );

		}

		/**
		 * @covers Base_Controller_CPT::add_model
		 * @depends testMethodAddModel
		 */
		public function testActionSavePostExists()
		{
			$cpt_model = $this->_createStubCptModel();
			$cpt_model->expects( $this->any() )
			          ->method( 'bar' )
			          ->will( $this->returnValue( 'barback' ) );

			$this->_controller->add_model( $cpt_model, 'foo', 'bar', 'baz' );
			$this->assertFalse( false === has_action( 'save_post', 'bar' ) );
		}

		/**
		 * @covers Base_Controller_CPT::add_model
		 * @depends testMethodAddModel
		 */
		public function testActionDeletePostExists()
		{
			$this->_controller->add_model( $this->_createStubCptModel(), 'foo', 'bar', 'baz' );
			$this->assertFalse( false === has_action( 'delete_post', 'baz' ) );
		}

		/**
		 * @covers Base_Controller_CPT::register
		 */
		public function testMethodRegister()
		{
			$this->assertTrue( method_exists( '\Base_Controller_CPT', 'register' ) );

			$cpt_model = $this->_createStubCptModel();

			$cpt_model->expects( $this->any() )
			          ->method( 'get_slug')
			          ->will( $this->returnValue( 'fooslug' ) );
			$cpt_model->expects( $this->any() )
			          ->method( 'get_args' )
			          ->will( $this->returnValue( 'fooargs' ) );

			//add the model to the controller's _cpt_models property
			$this->setReflectionPropertyValue( $this->_controller, '_cpt_models', array( 'fooslug' => $cpt_model ) );

			$this->_controller->register();
			$this->assertTrue( post_type_exists( 'fooslug' ) );
		}

		/**
		 * @covers Base_Controller_CPT::post_updated_messages
		 */
		public function testMethodPostUpdatedMessages()
		{
			$this->assertTrue( method_exists( $this->_controller, 'post_updated_messages' ) );

			//create a stub cpt model for testing
			$model = $this->_createStubCptModel();
			$model->expects( $this->any() )
				  ->method( 'get_post_updated_messages' )
				  ->will( $this->returnValue( array( 'foo' => 'bar' ) ) );
			$model->expects( $this->any() )
				  ->method( 'get_slug' )
				  ->will( $this->returnValue( 'fooslug' ) );

			//add the model to the controller's _cpt_models property
			$this->setReflectionPropertyValue( $this->_controller, '_cpt_models', array( 'fooslug' => $model ) );

			$messages = $this->_controller->post_updated_messages( array(), 'fooslug' );
			$this->assertArrayHasKey( 'fooslug', $messages, __( 'Messages not present in array', 'wpmvcb' ) );
			$this->assertEquals( array( 'foo' => 'bar' ), $messages['fooslug'] );
		}

		/**
		 * @covers Base_Controller_CPT::__construct
		 */
		public function testActionPostUpdatedMessagesExists()
		{
			$cpt_model = $this->_createStubCptModel();
			$this->_controller->add_model( $cpt_model );
			$this->assertFalse( false === has_action( 'post_updated_messages', array( $cpt_model, 'get_post_updated_messages' ) ) );
		}

		/**
		 * @covers Base_Controller_CPT::add_meta_boxes
		 */
		public function testMethodAddMetaBoxes()
		{
			$this->assertTrue( method_exists( $this->_controller, 'add_meta_boxes' ) );

			//create a stub metabox
			$metabox = $this->getMockBuilder( '\Base_Model_Metabox' )
			                ->setMethods( array( '__construct', 'get_id', 'get_title', 'get_callback', 'get_post_types', 'get_priority', 'get_context', 'get_callback_args' ) )
			                ->disableOriginalConstructor()
			                ->getMock();

			$metabox->expects( $this->any() )
			        ->method( 'get_id' )
			        ->will( $this->returnValue( 'foocptmetabox' ) );
			$metabox->expects( $this->any() )
			        ->method( 'get_title' )
			        ->will( $this->returnValue( 'Foo Metabox' ) );
			$metabox->expects( $this->any() )
			        ->method( 'get_callback' )
			        ->will( $this->returnValue( 'time' ) );
			$metabox->expects( $this->any() )
			        ->method( 'get_post_types' )
			        ->will( $this->returnValue( array( 'post', 'page' ) ) );
			$metabox->expects( $this->any() )
			        ->method( 'get_context' )
			        ->will( $this->returnValue( 'side' ) );
			$metabox->expects( $this->any() )
			        ->method( 'get_priority' )
			        ->will( $this->returnValue( 'high' ) );
			$metabox->expects( $this->any() )
			        ->method( 'get_callback_args' )
			        ->will( $this->returnValue( array( 'bar' => 'baz' ) ) );

			//stub the cpt model
			$model = $this->_createStubCptModel();

			$model->expects( $this->any() )
			      ->method( 'get_metaboxes' )
			      ->will( $this->returnValue( array( $metabox ) ) );

			//add the model to the controller
			$this->setReflectionPropertyValue( $this->_controller, '_cpt_models', array( 'foocptmetabox' => $model ) );

			$this->_controller->add_meta_boxes();

			$this->assertMetaboxExists( array( 'foocptmetabox', 'Foo Metabox', 'time', 'post', 'side', 'high', array( 'bar' => 'baz' ) ) );
			$this->assertMetaboxExists( array( 'foocptmetabox', 'Foo Metabox', 'time', 'page', 'side', 'high', array( 'bar' => 'baz' ) ) );
		}
		
		public function testMethodAdminEnqueueScripts()
		{
			$this->assertTrue( method_exists( $this->_controller, 'admin_enqueue_scripts' ) );
			$this->markTestIncomplete( 'Not yet implemented' );
		}
	}
}
