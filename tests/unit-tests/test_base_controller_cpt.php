<?php
namespace WPMVCB\Testing
{
	require_once( WPMVCB_SRC_DIR . '/controllers/base_controller_cpt.php' );
	
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
			
			$cpt_model = $this->getMockBuilder( '\Base_Model_CPT' )
							  ->disableOriginalConstructor()
							  ->getMock();
							  
			$this->_controller = new \Base_Controller_CPT( $cpt_model );
		}
		
		private function _createStubCptModel()
		{
			// Create stub for cpt_model
			$cpt_model = $this->getMockBuilder( '\Base_Model_CPT' )
						 ->disableOriginalConstructor()
						 ->setMethods( array( 'get_slug', 'get_args', 'get_post_updated_messages' ) )
						 ->getMock();
			
			return $cpt_model;
		}
		
		public function testPropertyCptModelExists()
		{
			$this->assertClassHasAttribute( 'cpt_model', '\Base_Controller_CPT' );
		}
		
		/**
		 * @expectedException PHPUnit_Framework_Error
		 * @expectedErrorMessage __constructor expects an object of type Base_Model_CPT
		 * @covers Base_Controller_CPT::__construct
		 */
		public function testMethodConstructorFail()
		{
			$object = new \stdClass;
			$controller = new \Base_Controller_CPT( $object );
		}
		
		public function testMethodAddModelExists()
		{
			$this->assertTrue( method_exists( $this->_controller, 'add_model' ) );
		}
		
		/**
		 * @depends testMethodAddModelExists
		 * @covers Base_Controller_CPT::add_model
		 */
		public function testMethodAddModel()
		{
			$cpt_model = $this->_createStubCptModel();
			$this->_controller->add_model( $cpt_model, 'foo', 'bar', 'baz' );
			$this->assertEquals( $cpt_model, $this->getReflectionPropertyValue( $this->_controller, 'cpt_model' ) );
		}
		
		/**
		 * @depends testMethodAddModelExists
		 * @covers Base_Controller_CPT::add_model
		 */
		public function testMethodAddModelFail()
		{
			$this->setExpectedException( 'PHPUnit_Framework_Error', 'add_model expects an object of type Base_Model_CPT' );
			$this->_controller->add_model( 'foo' );
		}
		
		public function testActionInitRegisterExists()
		{		 
			$this->assertTrue( method_exists( $this->_controller, 'register' ), __( 'Method does not exist', 'wmvcb' ) );
			$this->assertFalse( false === has_action( 'init', array( $this->_controller, 'register' ) ) );
		}
		
		public function testActionExistsAdminEnqueueScripts()
		{
			$this->assertFalse( false === has_action( 'admin_enqueue_scripts', array( $this->_controller, 'admin_enqueue_scripts' ) ) );
		}
		
		/**
		 * @depends testMethodAddModel
		 */
		public function testActionThePostExists()
		{
			$this->_controller->add_model( $this->_createStubCptModel(), 'foo', 'bar', 'baz' );
			$this->assertFalse( false === has_action( 'the_post', 'foo' ), __( 'Action the_post callback not registered', 'wpmvcb' ) );
			
		}
		
		/**
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
		 * @depends testMethodAddModel
		 */
		public function testActionDeletePostExists()
		{
			$this->_controller->add_model( $this->_createStubCptModel(), 'foo', 'bar', 'baz' );
			$this->assertFalse( false === has_action( 'delete_post', 'baz' ) );
		}
		
		/**
		 * @depends testMethodAddModel
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
			
			$this->_controller->add_model( $cpt_model );          
			
			$this->_controller->register();
			$this->assertTrue( post_type_exists( 'fooslug' ) );
		}
		
		/**
		 * @depends testMethodAddModel
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
				  
			$this->_controller->add_model( $model );
			
			$messages = $this->_controller->post_updated_messages( array() );
			$this->assertArrayHasKey( 'fooslug', $messages );
			$this->assertEquals( array( 'foo' => 'bar' ), $messages['fooslug'] );
		}
		
		/**
		 * @depends testMethodAddModel
		 */
		public function testActionPostUpdatedMessagesExists()
		{
			$cpt_model = $this->_createStubCptModel();
			$this->_controller->add_model( $cpt_model );
			$this->assertFalse( false === has_action( 'post_updated_messages', array( $cpt_model, 'get_post_updated_messages' ) ) );
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
	}
}
