<?php
namespace WPMVCB\Testing
{
	require_once WPMVCB_SRC_DIR . '/controllers/class-base-controller-plugin.php';
	
	/**
	 * The test controller for Base_Controller_Plugin
	 *
	 * @since WPMVCBase 0.1
	 * @internal
	 */
	 
	class BaseControllerPluginTest extends WPMVCB_Test_Case
	{
		public function setUp()
		{
			parent::setUp();
				
			//set up our virtual filesystem
			/*
\org\bovigo\vfs\vfsStreamWrapper::register();
			\org\bovigo\vfs\vfsStreamWrapper::setRoot( new \org\bovigo\vfs\vfsStreamDirectory( 'test_dir' ) );
			$this->_mock_path = trailingslashit( \org\bovigo\vfs\vfsStream::url( 'test_dir' ) );
			$this->_filesystem = \org\bovigo\vfs\vfsStreamWrapper::getRoot();
*/
			
			//set up the plugin model
			$this->_model = $this
				->getMockBuilder( '\Base_Model_Plugin' )
				->disableOriginalConstructor()
				->getMock();
						  
			//set up our controller
			$this->_controller = $this
				->getMockBuilder( '\Base_Controller_Plugin' )
				->setConstructorArgs( array( $this->_model ) )
				->getMockForAbstractClass();
		}
		
		public function tearDown()
		{
			unset( $this->_controller );
			unset( $this->_mock_path );
			unset( $this->_filesystem );
		}
		
		/**
		 * @expectedException PHPUnit_Framework_Error
		 * @expectedExceptionMessage __construct expects an instance of Base_Model_Plugin
		 * @covers Base_Controller_Plugin::__construct
		 */
		public function testMethodConstructorFail()
		{
			$model = new \stdClass;
			
			//set up our controller
			$controller = $this
				->getMockBuilder( '\Base_Controller_Plugin' )
				->setConstructorArgs( array( $model ) )
				->getMockForAbstractClass();
			
			unset( $controller );
		}
		
		public function testAttributePluginModelExists()
		{
			$this->assertClassHasAttribute( 'plugin_model', '\Base_Controller_Plugin' );
		}
		
		public function testActionAdminNoticesExists()
		{
			$this->assertFalse( false === has_action( 'admin_notices', array( $this->_controller, 'admin_notice' ) ) );
		}
		
		public function testActionPluginsLoadedExists()
		{
			$this->assertFalse( false === has_action( 'plugins_loaded', array( $this->_controller, 'load_text_domain' ) ) );
		}
		
		public function testActionAddMetaBoxesExists()
		{
			$this->assertFalse( false === has_action( 'add_meta_boxes', array( $this->_controller, 'add_meta_boxes' ) ) );
		}
		
		public function testActionAdminEnqueueScriptsExists()
		{
			$this->assertFalse( false === has_action( 'admin_enqueue_scripts', array( $this->_controller, 'admin_enqueue_scripts' ) ) );
		}

		public function testActionWpEnqueueScriptsExists()
		{
			$this->assertFalse( false === has_action( 'wp_enqueue_scripts', array( $this->_controller, 'wp_enqueue_scripts' ) ) );
		}
	}
}