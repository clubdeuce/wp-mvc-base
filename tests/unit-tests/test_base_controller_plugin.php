<?php
namespace WPMVCB\Testing {
    use \Base_Controller_Plugin;
    use \Base_Model_Plugin;
    use \PHPUnit_Framework_Error;
    use \Mockery;

    /**
     * The test controller for Base_Controller_Plugin
     *
     * @since WPMVCBase 0.1
     * @internal
     */
    class BaseControllerPluginTest extends WPMVCB_Test_Case
    {
        private $model;

        private $controller;

        public function setUp()
        {
            parent::setUp();

            //set up the plugin model
            $this->model = Mockery::mock('Base_Model_Plugin');
            $this->model->shouldReceive('get_help_tabs')->andReturn(array(
                'foo' => Mockery::mock('Base_Model_Help_Tab')->shouldReceive('get_screens')->andReturn('foo'),
                'bar' => Mockery::mock('Base_Model_Help_Tab')->shouldReceive('get_screens')->andReturn('foo'),
            ) );

            //set up our controller
            $this->controller = new Stub_Plugin_Controller( array( 'model' => $this->model ) );
        }

        public function tearDown()
        {
            wp_deregister_script('fooscript');
            unset($this->controller);
        }

        /**
         * @covers Base_Controller_Plugin::__construct
         */
        public function testAttributePluginModel()
        {
            $this->assertClassHasAttribute('pluginmodel', '\Base_Controller_Plugin');
            $this->assertSame($this->model, $this->getReflectionPropertyValue($this->controller, 'pluginmodel'));
        }

        public function testActionAdminNoticesExists()
        {
            $this->assertFalse(false === has_action('admin_notices', array($this->controller, 'admin_notice')));
        }

        public function testActionPluginsLoadedExists()
        {
            $this->assertFalse(false === has_action('plugins_loaded', array($this->controller, 'load_text_domain')));
        }

        public function testActionAddMetaBoxesExists()
        {
            $this->assertFalse(false === has_action('add_meta_boxes', array($this->controller, 'add_meta_boxes')));
        }

        public function testActionAdminEnqueueScriptsExists()
        {
            $this->assertFalse(false === has_action('admin_enqueue_scripts', array($this->controller, 'admin_enqueue_scripts')));
        }

        public function testActionWpEnqueueScriptsExists()
        {
            $this->assertFalse(false === has_action('wp_enqueue_scripts', array($this->controller, 'wp_enqueue_scripts')));
        }

        /**
         * covers Base_Controller_Plugin::wp_enqueue_scripts
         */
        public function testMethodWpEnqueueScripts()
        {
            $this->assertTrue(method_exists($this->controller, 'wp_enqueue_scripts'));

            $script = $this->getMockBuilder('\Base_Model_JS_Object')
                ->disableOriginalConstructor()
                ->setMethods(array('get_handle', 'get_src', 'get_deps', 'get_ver', 'get_in_footer'))
                ->getMock();

            $script->expects($this->any())
                ->method('get_handle')
                ->will($this->returnValue('fooscript'));

            $script->expects($this->any())
                ->method('get_src')
                ->will($this->returnValue('http://example.com/foo.js'));

            $script->expects($this->any())
                ->method('get_deps')
                ->will($this->returnValue(array('jquery')));

            $script->expects($this->any())
                ->method('get_ver')
                ->will($this->returnValue(true));

            $script->expects($this->any())
                ->method('get_in_footer')
                ->will($this->returnValue(true));

            $model = $this->getMockBuilder('\Base_Model_Plugin')
                ->disableOriginalConstructor()
                ->setMethods(array('get_scripts'))
                ->getMockForAbstractClass();

            $model->expects($this->any())
                ->method('get_scripts')
                ->will($this->returnValue(array($script)));

            //add the model to the controller
            $this->setReflectionPropertyValue($this->controller, 'pluginmodel', $model);

            //call the SUT
            $this->controller->wp_enqueue_scripts();

            //make sure script is registered
            $this->assertScriptRegistered(
                array(
                    'fooscript',
                    'http://example.com/foo.js',
                    array('jquery'),
                    true,
                    true
                )
            );

            //and enqueued
            $this->assertTrue(wp_script_is('fooscript', 'enqueued'), 'script not enuqueued');
        }

        /**
         * covers Base_Controller_Plugin::admin_enqueue_scripts
         */
        public function testMethodAdminEnqueueScripts()
        {
            $this->assertTrue(method_exists($this->controller, 'admin_enqueue_scripts'));

            $script = $this->getMockBuilder('\Base_Model_JS_Object')
                ->disableOriginalConstructor()
                ->setMethods(array('get_handle', 'get_src', 'get_deps', 'get_version', 'get_in_footer'))
                ->getMockForAbstractClass();

            $script->expects($this->any())
                ->method('get_handle')
                ->will($this->returnValue('fooadminscript'));

            $script->expects($this->any())
                ->method('get_src')
                ->will($this->returnValue('http://example.com/fooadmin.js'));

            $script->expects($this->any())
                ->method('get_deps')
                ->will($this->returnValue(array('jquery')));

            $script->expects($this->any())
                ->method('get_version')
                ->will($this->returnValue(true));

            $script->expects($this->any())
                ->method('get_in_footer')
                ->will($this->returnValue(true));

            $model = $this->getMockBuilder('\Base_Model_Plugin')
                ->disableOriginalConstructor()
                ->setMethods(array('get_admin_scripts', 'get_textdomain', 'get_uri'))
                ->getMockForAbstractClass();

            $model->expects($this->any())
                ->method('get_admin_scripts')
                ->will($this->returnValue(array($script)));

            $model->expects($this->any())
                ->method('get_textdomain')
                ->will($this->returnValue('footxtdomain'));

            $this->setReflectionPropertyValue($this->controller, 'pluginmodel', $model);

            $this->controller->admin_enqueue_scripts('foohook');

            $this->assertTrue(wp_script_is('fooadminscript', 'registered'));

            global $wp_scripts;

            $this->assertArrayHasKey('fooadminscript', $wp_scripts->registered);
            $this->assertEquals($wp_scripts->registered['fooadminscript']->handle, 'fooadminscript');
            $this->assertEquals($wp_scripts->registered['fooadminscript']->src, 'http://example.com/fooadmin.js');
            $this->assertEquals($wp_scripts->registered['fooadminscript']->deps, array('jquery'));
            $this->assertEquals($wp_scripts->registered['fooadminscript']->ver, true);
            $this->assertEquals($wp_scripts->registered['fooadminscript']->extra, array('group' => 1));
        }
    }

    class Stub_Plugin_Controller extends Base_Controller_Plugin
    {
        public function __construct( array $args = array() )
        {
            $args = wp_parse_args( $args, array(
                'model' => Mockery::mock( 'Base_Model_Plugin' ),
            ) );

            parent::__construct( $args );
        }
    }
}
