<?php
namespace WPMVCB\Testing
{
	require_once( WPMVCB_SRC_DIR . '/controllers/class-base-controller.php' );

	/**
	 * The test controller for Base_Controller_Plugin
	 *
	 * @since WPMVCBase 0.1
	 * @internal
	 */

	class testBaseController extends WPMVCB_Test_Case
	{
		public function setUp()
		{
			parent::setUp();

			//set up the virtual filesystem
			\org\bovigo\vfs\vfsStreamWrapper::register();
			\org\bovigo\vfs\vfsStreamWrapper::setRoot( new \org\bovigo\vfs\vfsStreamDirectory( 'test_dir' ) );
			$this->_mock_path = trailingslashit( \org\bovigo\vfs\vfsStream::url( 'test_dir' ) );
			$this->_filesystem = \org\bovigo\vfs\vfsStreamWrapper::getRoot();

			$this->_controller = new \Base_Controller(
				'/home/foo/plugin.php',
				'/home/foo/app',
				'/home/foo/base',
				'http://example.com/foo',
				'footextdomain'
			);
		}

		public function tearDown()
		{
			wp_deregister_script( 'fooscript' );
			unset( $this->_mock_path );
			unset( $this->_filesystem );
			unset( $this->_controller );
		}
		
		/**
		 * @covers Base_Controller::__construct
		 */
		public function testActionExistsWpEnqueueScripts()
		{
			$this->assertFalse(
				false === has_action( 'wp_enqueue_scripts', array( &$this->_controller, 'wp_enqueue_scripts' ) ),
				'wp_enqueue_scripts not hooked'
			);
		}
		
		/**
		 * @covers Base_Controller::__construct
		 */
		public function testActionExistsAddMetaBoxes()
		{
			$this->assertFalse(
				false === has_action( 'add_meta_boxes', array( &$this->_controller, 'add_meta_boxes' ) ),
				'wp_enqueue_scripts not hooked'
			);
		}
		
		/**
		 * @covers Base_Controller::__construct
		 */
		public function testActionExistsAdminEnqueueScripts()
		{
			$this->assertFalse(
				false === has_action( 'admin_enqueue_scripts', array( &$this->_controller, 'admin_enqueue_scripts' ) ),
				'add_meta_boxes not hooked'
			);
		}
		
		public function testMethodExistsAddShortcodes()
		{
			$this->assertTrue( method_exists( $this->_controller, 'add_shortcodes' ) );
		}

		/**
		 * @covers Base_Controller::add_shortcodes
		 * @uses   Base_Controller::__construct
		 * @depends testMethodExistsAddShortcodes
		 */
		public function testMethodAddShortcodes()
		{
			$this->_controller->add_shortcodes( array( 'foo' => array( &$this, 'tearDown' ) ) );
			$this->assertTrue( shortcode_exists( 'foo' ) );
			remove_shortcode( 'foo' );
		}

		/**
		 * @covers            Base_Controller::add_shortcodes
		 * @uses              Base_Controller::__construct
		 * @depends           testMethodExistsAddShortcodes
		 * @expectedException PHPUnit_Framework_Error
		 */
		public function testMethodAddShortcodesNonArray()
		{
				$this->_controller->add_shortcodes( 'foo' );
		}
		
		/**
		 * @covers Base_Controller::add_meta_boxes
		 * @uses   Base_Controller::__construct
		 * @uses   Base_Controller::add_shortcodes
		 */
		public function testMethodAddMetaboxes()
		{
			$this->assertTrue( method_exists( $this->_controller, 'add_meta_boxes' ) );

			//create a stub metabox
			$metabox = $this->getMockBuilder( '\Base_Model_Metabox' )
			                ->setMethods( array( 'get_id', 'get_title', 'get_callback', 'get_post_types', 'get_priority', 'get_context', 'get_callback_args' ) )
			                ->disableOriginalConstructor()
			                ->getMock();

			$metabox->expects( $this->any() )
			        ->method( 'get_id' )
			        ->will( $this->returnValue( 'cptcontroller' ) );
			$metabox->expects( $this->any() )
			        ->method( 'get_title' )
			        ->will( $this->returnValue( 'Foo Metabox' ) );
			$metabox->expects( $this->any() )
			        ->method( 'get_callback' )
			        ->will( $this->returnValue( 'time' ) );
			$metabox->expects( $this->any() )
			        ->method( 'get_post_types' )
			        ->will( $this->returnValue( array( 'cptpost', 'cptpage' ) ) );
			$metabox->expects( $this->any() )
			        ->method( 'get_context' )
			        ->will( $this->returnValue( 'normal' ) );
			$metabox->expects( $this->any() )
			        ->method( 'get_priority' )
			        ->will( $this->returnValue( 'default' ) );
			$metabox->expects( $this->any() )
			        ->method( 'get_callback_args' )
			        ->will( $this->returnValue( array( 'foo' => 'bar' ) ) );

			$this->_controller->add_meta_boxes( array( $metabox ) );

			$this->assertMetaboxExists( array( 'cptcontroller', 'Foo Metabox', 'time', 'cptpost', 'normal', 'default', array( 'foo' => 'bar' ) ) );
			$this->assertMetaboxExists( array( 'cptcontroller', 'Foo Metabox', 'time', 'cptpage', 'normal', 'default', array( 'foo' => 'bar' ) ) );
		}
		
		/**
		 * @covers Base_Controller::add_meta_boxes
		 * @uses   Base_Controller::__construct
		 */
		public function testMethodAddMetaboxesEmptyCallback()
		{
			$this->assertTrue( method_exists( $this->_controller, 'add_meta_boxes' ) );

			//create a stub metabox
			$metabox = $this->getMockBuilder( '\Base_Model_Metabox' )
			                ->setMethods( array( 'get_id', 'get_title', 'get_callback', 'get_post_types', 'get_priority', 'get_context', 'get_callback_args' ) )
			                ->disableOriginalConstructor()
			                ->getMock();

			$metabox->expects( $this->any() )
			        ->method( 'get_id' )
			        ->will( $this->returnValue( 'cptcontroller' ) );
			$metabox->expects( $this->any() )
			        ->method( 'get_title' )
			        ->will( $this->returnValue( 'Foo Metabox' ) );
			$metabox->expects( $this->any() )
			        ->method( 'get_callback' )
			        ->will( $this->returnValue( null ) );
			$metabox->expects( $this->any() )
			        ->method( 'get_post_types' )
			        ->will( $this->returnValue( array( 'cptpost', 'cptpage' ) ) );
			$metabox->expects( $this->any() )
			        ->method( 'get_context' )
			        ->will( $this->returnValue( 'normal' ) );
			$metabox->expects( $this->any() )
			        ->method( 'get_priority' )
			        ->will( $this->returnValue( 'default' ) );
			$metabox->expects( $this->any() )
			        ->method( 'get_callback_args' )
			        ->will( $this->returnValue( array( 'foo' => 'bar' ) ) );

			$this->_controller->add_meta_boxes( array( $metabox ) );

			$this->assertMetaboxExists( 
				array( 
					'cptcontroller',
					'Foo Metabox',
					array( &$this->_controller, 'render_metabox' ),
					'cptpost',
					'normal',
					'default',
					array( 'foo' => 'bar' ) 
				) 
			);
			$this->assertMetaboxExists(
				array(
					'cptcontroller',
					'Foo Metabox', 
					array( &$this->_controller, 'render_metabox' ),
					'cptpage',
					'normal',
					'default', 
					array( 'foo' => 'bar' ) 
				) 
			);
		}
		
		public function testMethodExistsRenderMetabox()
		{
			$this->assertTrue( method_exists( $this->_controller, 'render_metabox' ) );
		}

		/**
		 * @depends testMethodExistsRenderMetabox
		 * @covers Base_Controller::render_metabox
		 * @uses   Base_Controller::__construct
		 */
		public function testRenderMetaboxNoViewSpecified()
		{
			$metabox = array(
				'id' => 'test-metabox',
				'args' => array()
			);
			
			//set up a post object 
			$factory = new \WP_UnitTest_Factory;
			
			$post_id = $factory->post->create_object(
				array(
					'post_title'  => 'Test Render Metabox',
					'post_type'   => 'post',
					'post_status' => 'publish'
				)
			);
			
			$this->expectOutputString( 'No view specified in the callback arguments for metabox id test-metabox' );
			$this->_controller->render_metabox( get_post( $post_id ), $metabox );
		}

		/**
		 * @depends testMethodExistsRenderMetabox
		 * @covers Base_Controller::render_metabox
		 * @uses   Base_Controller::__construct
		 */
		public function testRenderMetaboxViewNonexistent()
		{
			$metabox = array(
				'id' => 'test-metabox',
				'args' => array(
					'view' => 'foo.php'
				)
			);
			
			//set up a post object 
			$factory = new \WP_UnitTest_Factory;
			
			$post_id = $factory->post->create_object(
				array(
					'post_title'  => 'Test Render Metabox',
					'post_type'   => 'post',
					'post_status' => 'publish'
				)
			);
			
			$this->expectOutputString( 'The view file foo.php for metabox id test-metabox does not exist' );
			$this->_controller->render_metabox( get_post( $post_id ), $metabox );
		}

		/**
		 * @depends testMethodExistsRenderMetabox
		 * @covers Base_Controller::render_metabox
		 * @uses   Base_Controller::__construct
		 */
		public function testMethodRenderMetabox()
		{
			//create our mock view directory
			mkdir( $this->_mock_path . 'app/views', 0755, true );
			$this->assertTrue( $this->_filesystem->hasChild( 'app/views' ) );

			//create our mock View file
			$handle = fopen( $this->_mock_path . 'app/views/foo.php', 'w' );
			fwrite( $handle, 'This is foo.' );
			fclose( $handle );
			$this->assertFileExists( $this->_mock_path . 'app/views/foo.php' );
			
			//set up a metabx
			$metabox = array(
				'id' => 'test-metabox',
				'args' => array(
					'view' =>  $this->_mock_path . 'app/views/foo.php'
				)
			);
			
			//set up a post object 
			$factory = new \WP_UnitTest_Factory;
			
			$post_id = $factory->post->create_object(
				array(
					'post_title'  => 'Test Render Metabox',
					'post_type'   => 'post',
					'post_status' => 'publish'
				)
			);
			
			$this->expectOutputString( 'This is foo.' );

			$this->_controller->render_metabox( get_post( $post_id ), $metabox, 'foo', 'bar', 'baz' );
		}
		
		/**
		 * @covers Base_Controller::enqueue_scripts
		 * @uses   Base_Controller::__construct
		 */
		public function testMethodEnqueueScripts()
		{
			$this->assertTrue( method_exists( $this->_controller, 'enqueue_scripts' ), 'enqueue_scripts() does not exist' );
			
			//create a stub Base_Model_JS_Object
			$script = $this->getMockBuilder( '\Base_Model_JS_Object' )
			               ->disableOriginalConstructor()
			               ->setMethods( array( 'get_handle', 'get_src', 'get_deps', 'get_ver', 'get_in_footer' ) )
			               ->getMock();
			
			$script->expects( $this->any() )
			       ->method( 'get_handle' )
			       ->will( $this->returnValue( 'fooscript' ) );
			       
			$script->expects( $this->any() )
			       ->method( 'get_src' )
			       ->will( $this->returnValue('http://example.com/foo.js' ) );
			       
			$script->expects( $this->any() )
			       ->method( 'get_deps' )
			       ->will( $this->returnValue( array( 'jquery' ) ) );
			       
			$script->expects( $this->any() )
			       ->method( 'get_ver' )
			       ->will( $this->returnValue( true ) );
			       
			$script->expects( $this->any() )
			       ->method( 'get_in_footer' )
			       ->will( $this->returnValue( true ) );
			
			$this->_controller->enqueue_scripts( array( 'fooscript' => $script ) );
			
			//make sure script is registered
			$this->assertScriptRegistered( 
				array(
					'fooscript',
					'http://example.com/foo.js',
					array( 'jquery' ),
					true,
					true
				)
			);
			
			//and enqueued
			$this->assertTrue( wp_script_is( 'fooscript', 'enqueued' ), 'script not enuqueued' );
		}
		
		/**
		 * In this test, we pass an non-array to the method.
		 *
		 * @covers Base_Controller::enqueue_scripts
		 * @uses   Base_Controller::__construct
		 * @expectedException PHPUnit_Framework_Error
		 */
		public function testMethodEnqueueScriptsNonArray()
		{
			$this->_controller->enqueue_scripts( 'foo' );
		}
		
		/**
		 * In this test, we pass an array that does not contain Base_Model_JS_Objects.
		 *
		 * @covers Base_Controller::enqueue_scripts
		 * @uses   Base_Controller::__construct
		 */
		public function testMethodEnqueueScriptsInvalidScriptObject()
		{
			$script = new \StdClass();
			
			$this->assertEquals(
				new \WP_Error(
					'invalid object type',
					'fooscript is not a Base_Model_JS_Object',
					$script
				),
				$this->_controller->enqueue_scripts( array( 'fooscript' => $script ) )
			);
		}
	}
}
