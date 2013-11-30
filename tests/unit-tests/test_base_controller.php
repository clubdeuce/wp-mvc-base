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

	class BaseControllerTest extends WPMVCB_Test_Case
	{
		public function setUp()
		{
			parent::setUp();

			//set up the virtual filesystem
			\org\bovigo\vfs\vfsStreamWrapper::register();
			\org\bovigo\vfs\vfsStreamWrapper::setRoot( new \org\bovigo\vfs\vfsStreamDirectory( 'test_dir' ) );
			$this->_mock_path = trailingslashit( \org\bovigo\vfs\vfsStream::url( 'test_dir' ) );
			$this->_filesystem = \org\bovigo\vfs\vfsStreamWrapper::getRoot();

			$this->_controller = new \Base_Controller();
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
		 * @depends testMethodExistsAddShortcodes
		 */
		public function testMethodAddShortcodes()
		{
			$this->_controller->add_shortcodes( array( 'foo' => array( &$this, 'tearDown' ) ) );
			$this->assertTrue( shortcode_exists( 'foo' ) );
			remove_shortcode( 'foo' );
		}

		/**
		 * @covers Base_Controller::add_shortcodes
		 * @depends testMethodExistsAddShortcodes
		 */
		public function testMethodAddShortcodesNonArray()
		{
			$this->assertEquals(
				new \WP_Error(
					'non-array',
					'Base_Controller::add_shortcodes expects an array',
					'foo'
				),
				$this->_controller->add_shortcodes( 'foo' )
			);
		}

		public function testMethodExistsRenderMetabox()
		{
			$this->assertTrue( method_exists( $this->_controller, 'render_metabox' ) );
		}

		/**
		 * @depends testMethodExistsRenderMetabox
		 * @expectedException PHPUnit_Framework_Error
		 * @expectedExceptionMessage No view specified in the callback arguments for metabox id test-metabox
		 * @covers Base_Controller::render_metabox
		 */
		public function testRenderMetaboxNoViewSpecified()
		{
			$metabox = array(
				'id' => 'test-metabox',
				'args' => array()
			);

			$this->_controller->render_metabox( $this->_post, $metabox );
		}

		/**
		 * @depends testMethodExistsRenderMetabox
		 * @expectedException PHPUnit_Framework_Error
		 * @expectedExceptionMessage The view file foo.php for metabox id test-metabox does not exist
		 * @covers Base_Controller::render_metabox
		 */
		public function testRenderMetaboxViewNonexistent()
		{
			$metabox = array(
				'id' => 'test-metabox',
				'args' => array(
					'view' => 'foo.php'
				)
			);

			$this->_controller->render_metabox( $this->_post, $metabox );
		}

		/**
		 * @depends testMethodExistsRenderMetabox
		 * @covers Base_Controller::render_metabox
		 */
		public function testRenderMetabox()
		{
			//create our mock view directory
			mkdir( $this->_mock_path . 'app/views', 0755, true );
			$this->assertTrue( $this->_filesystem->hasChild( 'app/views' ) );

			//create our mock View file
			$handle = fopen( $this->_mock_path . 'app/views/foo.php', 'w' );
			fwrite( $handle, 'This is foo.' );
			fclose( $handle );
			$this->assertFileExists( $this->_mock_path . 'app/views/foo.php' );

			$metabox = array(
				'id' => 'test-metabox',
				'args' => array(
					'view' =>  $this->_mock_path . 'app/views/foo.php'
				)
			);

			//set up class attributes necessary for the function
			$this->_controller->nonce_name = 'foo_nonce_name';
			$this->_controller->nonce_action = 'foo_nonce_action';
			$this->_controller->txtdomain = 'foo_txtdomain';

			$this->expectOutputString( 'This is foo.' );

			$this->_controller->render_metabox( $this->_post, $metabox, 'foo', 'bar', 'baz' );
		}

		/**
		 * @covers Base_Controller::authenticate_post
		 */
		public function testMethodAuthenticatePostForPost()
		{
			$this->assertTrue( method_exists( $this->_controller, 'authenticate_post' ) );
			$factory = new \WP_UnitTest_Factory;

			$post_id = $factory->post->create_object(
				array(
					'post_title' => 'Test Post',
					'post_type' => 'post',
					'post_status' => 'publish'
				)
			);

			wp_set_current_user( 1 );

			$this->assertTrue(
				$this->_controller->authenticate_post(
					$post_id,
					'post',
					array( 'foo_name' => wp_create_nonce( 'foo_action' ) ),
					'foo_name',
					'foo_action'
				)
			);
		}

		/**
		 * @covers Base_Controller::authenticate_post
		 */
		public function testMethodAuthenticatePostForPage()
		{
			$this->assertTrue( method_exists( $this->_controller, 'authenticate_post' ) );
			$factory = new \WP_UnitTest_Factory;

			$post_id = $factory->post->create_object(
				array(
					'post_title' => 'Test Post',
					'post_type' => 'page',
					'post_status' => 'publish'
				)
			);

			wp_set_current_user( 1 );

			$this->assertTrue(
				$this->_controller->authenticate_post(
					$post_id,
					'page',
					array( 'foo_name' => wp_create_nonce( 'foo_action' ) ),
					'foo_name',
					'foo_action'
				)
			);
		}

		/**
		 * @covers Base_Controller::authenticate_post
		 */
		public function testMethodAuthenticatePostUserCannotEditPage()
		{
			$this->assertTrue( method_exists( $this->_controller, 'authenticate_post' ) );
			$factory = new \WP_UnitTest_Factory;

			$post_id = $factory->post->create_object(
				array(
					'post_title' => 'Test Post',
					'post_type' => 'page',
					'post_status' => 'publish'
				)
			);

			wp_set_current_user( 0 );

			$this->assertEmpty(
				$this->_controller->authenticate_post(
					$post_id,
					'page',
					array( 'foo_name' => wp_create_nonce( 'foo_action' ) ),
					'foo_name',
					'foo_action'
				)
			);
		}

		/**
		 * @covers Base_Controller::authenticate_post
		 */
		public function testMethodAuthenticatePostUserCannotEditPost()
		{
			$this->assertTrue( method_exists( $this->_controller, 'authenticate_post' ) );
			$factory = new \WP_UnitTest_Factory;

			$post_id = $factory->post->create_object(
				array(
					'post_title' => 'Test Post',
					'post_type' => 'post',
					'post_status' => 'publish'
				)
			);

			wp_set_current_user( 0 );

			$this->assertEmpty(
				$this->_controller->authenticate_post(
					$post_id,
					'post',
					array( 'foo_name' => wp_create_nonce( 'foo_action' ) ),
					'foo_name',
					'foo_action'
				)
			);
		}

		/**
		 * @covers Base_Controller::authenticate_post
		 */
		public function testMethodAuthenticatePostNoNonce()
		{
			$this->assertTrue( method_exists( $this->_controller, 'authenticate_post' ) );
			$factory = new \WP_UnitTest_Factory;

			$post_id = $factory->post->create_object(
				array(
					'post_title' => 'Test Post',
					'post_type' => 'page',
					'post_status' => 'publish'
				)
			);

			wp_set_current_user( 1 );

			$this->assertEmpty(
				$this->_controller->authenticate_post(
					$post_id,
					'page',
					array(),
					'foo_name',
					'foo_action'
				)
			);
		}

		/**
		 * @covers Base_Controller::authenticate_post
		 */
		public function testMethodAuthenticatePostDoingAutosave()
		{
			$this->assertTrue( method_exists( $this->_controller, 'authenticate_post' ) );

			define( 'DOING_AUTOSAVE', true );

			$this->assertEmpty(
				$this->_controller->authenticate_post(
					$post_id,
					'page',
					array( 'foo_name' => wp_create_nonce( 'foo_action' ) ),
					'foo_name',
					'foo_action'
				)
			);
		}
		
		/**
		 * @covers Base_Controller::enqueue_scripts
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
		 * In this test, we pass an array that does not contain Base_Model_JS_Objects. The test should fail.
		 *
		 * @expectedException PHPUnit_Framework_Error
		 * @ExpectedExceptionMessage fooscript is not a Base_Model_JS_Object
		 * @covers Base_Controller::enqueue_scripts
		 */
		public function testMethodEnqueueScriptsFail()
		{
			$this->_controller->enqueue_scripts( array( 'fooscript' => new \StdClass ) );
		}
	}
}
