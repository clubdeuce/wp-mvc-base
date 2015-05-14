<?php
namespace WPMVCB\Testing\UnitTests {

	use \WPMVCB\Testing\WPMVCB_Test_Case;
    use \WPMVC_Controller_Base;
    use \Mockery;
    use \org\bovigo\vfs\vfsStreamWrapper;
    use \org\bovigo\vfs\vfsStreamDirectory;
    use \org\bovigo\vfs\vfsStream;

	/**
	 * The test controller for Base_Controller_Plugin
	 *
	 * @group    Base
	 * @group    Controllers
	 * @since    WPMVCBase 0.1
	 * @internal
	 */

	class testBaseController extends WPMVCB_Test_Case
	{
        /**
         * @var string
         */
        private $_mock_path;

        /**
         * @var string
         */
        private $_filesystem;

        /**
         * @var Stub_Controller
         */
        private $_controller;

		public function setUp()
		{
			parent::setUp();

			//set up the virtual filesystem
			vfsStreamWrapper::register();
			vfsStreamWrapper::setRoot( new vfsStreamDirectory( 'test_dir' ) );
			$this->_mock_path = trailingslashit( vfsStream::url( 'test_dir' ) );
			$this->_filesystem = vfsStreamWrapper::getRoot();

			$this->_controller = new Stub_Controller();
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
		
		// public function testMethodExistsRenderMetabox()
		// {
		// 	$this->assertTrue( method_exists( $this->_controller, 'render_metabox' ) );
		// }

		// /**
		//  * @depends testMethodExistsRenderMetabox
		//  * @covers Base_Controller::render_metabox
		//  * @uses   Base_Controller::__construct
		//  */
		// public function testRenderMetaboxNoViewSpecified()
		// {
		// 	$metabox = array(
		// 		'id' => 'test-metabox',
		// 		'args' => array()
		// 	);
			
		// 	//set up a post object 
		// 	$factory = new \WP_UnitTest_Factory;
			
		// 	$post_id = $factory->post->create_object(
		// 		array(
		// 			'post_title'  => 'Test Render Metabox',
		// 			'post_type'   => 'post',
		// 			'post_status' => 'publish'
		// 		)
		// 	);
			
		// 	$this->expectOutputString( 'No view specified in the callback arguments for metabox id test-metabox' );
		// 	$this->_controller->render_metabox( get_post( $post_id ), $metabox );
		// }

		// /**
		//  * @depends testMethodExistsRenderMetabox
		//  * @covers Base_Controller::render_metabox
		//  * @uses   Base_Controller::__construct
		//  */
		// public function testRenderMetaboxViewNonexistent()
		// {
		// 	$metabox = array(
		// 		'id' => 'test-metabox',
		// 		'args' => array(
		// 			'view' => 'foo.php'
		// 		)
		// 	);
			
		// 	//set up a post object 
		// 	$factory = new \WP_UnitTest_Factory;
			
		// 	$post_id = $factory->post->create_object(
		// 		array(
		// 			'post_title'  => 'Test Render Metabox',
		// 			'post_type'   => 'post',
		// 			'post_status' => 'publish'
		// 		)
		// 	);
			
		// 	$this->expectOutputString( 'The view file foo.php for metabox id test-metabox does not exist' );
		// 	$this->_controller->render_metabox( get_post( $post_id ), $metabox );
		// }

		// /**
		//  * @depends testMethodExistsRenderMetabox
		//  * @covers Base_Controller::render_metabox
		//  * @uses   Base_Controller::__construct
		//  */
		// public function testMethodRenderMetabox()
		// {
		// 	//create our mock view directory
		// 	mkdir( $this->_mock_path . 'app/views', 0755, true );
		// 	$this->assertTrue( $this->_filesystem->hasChild( 'app/views' ) );

		// 	//create our mock View file
		// 	$handle = fopen( $this->_mock_path . 'app/views/foo.php', 'w' );
		// 	fwrite( $handle, 'This is foo.' );
		// 	fclose( $handle );
		// 	$this->assertFileExists( $this->_mock_path . 'app/views/foo.php' );
			
		// 	//set up a metabx
		// 	$metabox = array(
		// 		'id' => 'test-metabox',
		// 		'args' => array(
		// 			'view' =>  $this->_mock_path . 'app/views/foo.php'
		// 		)
		// 	);
			
		// 	//set up a post object 
		// 	$factory = new \WP_UnitTest_Factory;
			
		// 	$post_id = $factory->post->create_object(
		// 		array(
		// 			'post_title'  => 'Test Render Metabox',
		// 			'post_type'   => 'post',
		// 			'post_status' => 'publish'
		// 		)
		// 	);
			
		// 	$this->expectOutputString( 'This is foo.' );

		// 	$this->_controller->render_metabox( get_post( $post_id ), $metabox, 'foo', 'bar', 'baz' );
		// }
		
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

		/**
		 * @covers Base_Controller::__call
		 */
		public function testMethodCallonModel() {

			$stub = new Stub_Controller(array('model' => new Stub_Model));

			$this->assertEquals('bar', $stub->foo());
		}

		/**
		 * @covers Base_Controller::__call
		 */
		public function testMethodCallOnView() {

			$stub = new Stub_Controller( array('view' => new Stub_View));

			$this->assertEquals('bar', $stub->foo());

		}

		/**
		 * @covers Base_Controller::__call
		 */
		public function testMethodCallError() {

			$result = @$this->_controller->foo();
			$this->assertInstanceOf('WP_Error', $result);
			$this->assertNotEmpty($result->get_error_message());

		}

		/**
		 * @covers Base_Controller::__get
		 */
		public function testMethodGetOnModel() {
			
			$stub = new Stub_Controller(array('model' => new Stub_Model));

			$this->assertEquals('bar', $stub->foo);
		}

		/**
		 * @covers Base_Controller::__get
		 */
		public function testMethodGetOnView() {

			$stub = new Stub_Controller(array('view' => new Stub_View));

			$this->assertEquals('bar', $stub->foo);

		}

		/**
		 * @covers Base_Controller::__get
		 */
		public function testMethodGetOnModelError() {

			$result = @$this->_controller->foo;
			$this->assertInstanceOf('WP_Error', $result);
			$this->assertNotEmpty($result->get_error_message());

		}
	}

    /**
     * Class Stub_Controller
     *
     * @package  WPMVCB\Testing
     * @internal
     */
    class Stub_Controller extends WPMVC_Controller_Base
    {
    }

    /**
     * Class Stub_Model
     *
     * @package  WPMVCB\Testing
     * @internal
     */
    class Stub_Model {

    	public $foo = 'bar';

    	public function foo() {

    		return $this->foo;

    	}

    }

    /**
     * Class Stub_View
     *
     * @package  WPMVCB\Testing
     * @internal
     */
    class Stub_View {

    	public $foo = 'bar';

    	public function foo() {

    		return $this->foo;

    	}

    }
    
}
