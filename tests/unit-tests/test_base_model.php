<?php
namespace WPMVCB\Testing\UnitTests {

	use \WPMVCB\Testing\WPMVCB_Test_Case;
    use \WPMVCB_Model_Base;
    use \WP_Error;
    
	//require_once WPMVCB_SRC_DIR . '/helpers/class-base-helpers.php';
	//require_once WPMVCB_SRC_DIR . '/models/class-model-base.php';
		
	/**
	 * Base Model Test Class
	 *
	 * @coversDefaultClass WPMVCB_Model_Base
	 * @group              Base
	 * @internal
	 * @since 0.1
	 */
	class testBaseModel extends WPMVCB_Test_Case
	{
        /**
         * @var Stub_Base_Model
         */
        private $model;

		public function setUp() {

			parent::setUp();
			
			$args = array(
				'/home/foo/plugin.php',
				'/home/foo',
				'/home/foo/app',
				'/home/foo/base',
				'http://example.com/foo',
				'footextdomain'
			);
			
			//create the model
			$this->model = new Stub_Base_Model( $args );

		}
		
		public function tearDown() {

			unset( $this->model );

		}

		/**
		 * @covers ::get_css
		 */
		public function testMethodGetCss() {

			$this->assertClassHasAttribute( 'css', 'WPMVCB_Model_Base' );
			$this->assertTrue( method_exists( $this->model, 'get_css' ) );
			$this->setReflectionPropertyValue( $this->model, 'css', array( 'foo_css' => array( 'handle' => 'bar_css' ) ) );
			
			$this->assertEquals(
				array( 'foo_css' => array( 'handle' => 'bar_css' ) ),
				$this->model->get_css( 'http://my-super-cool-site' )
			);

		}
		
		/**
		 * @covers ::get_css
		 */
		public function testMethodGetCssEmpty() {

			$this->assertTrue( method_exists( $this->model, 'get_css' ) );
			$this->assertEmpty( $this->model->get_css() );

		}
		
		/**
		 * @covers ::get_admin_css
		 */
		public function testMethodGetAdminCss() {

			$this->assertClassHasAttribute( 'admin_css', 'WPMVCB_Model_Base' );
			$this->assertTrue( method_exists( $this->model, 'get_admin_css' ) );
			$this->setReflectionPropertyValue( $this->model, 'admin_css', array( 'foo_admin_css' => array( 'handle' => 'bar_admin_css' ) ) );
			$this->assertEquals(
				array( 'foo_admin_css' => array( 'handle' => 'bar_admin_css' ) ),
				$this->model->get_admin_css( 'http://my-super-cool-site' )
			);
		}
		
		/**
		 * @covers ::get_admin_css
		 */
		public function testMethodGetAdminCssEmpty() {

			$this->assertTrue( method_exists( $this->model, 'get_admin_css' ) );
			$this->assertEmpty( $this->model->get_admin_css() );

		}
		
		/**
		 * @covers ::get_scripts
		 */
		public function testMethodGetScripts() {

			$this->assertClassHasAttribute( 'scripts', 'WPMVCB_Model_Base' );
			$this->assertTrue( method_exists( $this->model, 'get_scripts' ) );
			//global $post;
			
			$this->setReflectionPropertyValue( $this->model, 'scripts', array ( 'foo_scripts' => 'bar_scripts' ) );
			$this->assertEquals(
				array ( 'foo_scripts' => 'bar_scripts' ),
				$this->model->get_scripts()
			);

		}
		
		/**
		 * @covers ::get_scripts
		 */
		public function testMethodGetScriptsEmpty() {

			$this->assertTrue( method_exists( $this->model, 'get_scripts' ) );
			$this->assertEmpty( $this->model->get_scripts() );

		}
		
		/**
		 * @covers ::get_admin_scripts
		 */
		public function testMethodGetAdminScripts() {

			$this->assertClassHasAttribute( 'admin_scripts', 'WPMVCB_Model_Base' );
			$this->assertTrue( method_exists( $this->model, 'get_admin_scripts' ) );
			
			//global $post;
			$this->setReflectionPropertyValue( $this->model, 'admin_scripts', array( 'foo_admin_scripts' => 'bar_admin_scripts' ) );
			$this->assertEquals(
				array( 'foo_admin_scripts' => 'bar_admin_scripts' ),
				$this->model->get_admin_scripts()
			);

		}
		
		/**
		 * @covers ::get_admin_scripts
		 */
		public function testMethodGetAdminScriptsEmpty() {

			$this->assertTrue( method_exists( $this->model, 'get_admin_scripts' ) );
			$this->assertEmpty( $this->model->get_admin_scripts() );

		}
		
		/**
		 * @covers ::get_metaboxes
		 */
		public function testMethodGetMetaboxes() {

			$this->assertClassHasAttribute( 'metaboxes', 'WPMVCB_Model_Base' );
			$this->assertTrue( method_exists( $this->model, 'get_metaboxes' ) );
			
			$stub = $this->getMockBuilder( 'WPMVCB_Model_Base_Metabox' )
						 ->disableOriginalConstructor()
						 ->getMock();
			$this->setReflectionPropertyValue( $this->model, 'metaboxes', array( 'foo' => $stub ) );
			
			$this->assertEquals( array( 'foo' => $stub ), $this->model->get_metaboxes( 'bar', 'baz') );

		}
		
		/**
		 * @covers ::get_metaboxes
		 */
		public function testMethodGetmetaboxesEmpty() {

			$this->assertTrue( method_exists( $this->model, 'get_metaboxes' ) );
			$this->assertEmpty( $this->model->get_metaboxes() );

		}
		
		/**
		 * @covers ::add_help_tab
		 */
		public function testMethodAddHelpTab() {

			$this->assertClassHasAttribute( 'help_tabs', 'WPMVCB_Model_Base' );
			$this->assertTrue( method_exists( $this->model, 'add_help_tab' ) );
			//set up our mock help tab object
			$stub = $this->getMockBuilder( 'Base_Model_Help_Tab' )
						 ->disableOriginalConstructor()
						 ->getMock();
			
			$this->model->add_help_tab( 'foo', $stub );
			
			$this->assertEquals( 
				array( 'foo' => $stub ),
				$this->getReflectionPropertyValue( $this->model, 'help_tabs' ),
				'Help tab not properly set'
			);

		}
		
		/**
		 * Pass an object not of type WPMVCB_Model_Base_Help_Tab. Verify WP_Error object is returned
		 * and that error object data equals the passed in tab object
		 * 
		 * @covers ::add_help_tab
		 */
		public function testMethodAddHelpTabFail() {

			$this->assertTrue( method_exists( $this->model, 'add_help_tab' ) );
			
			$tab = new \StdClass;

			$result = $this->model->add_help_tab( 'foo', $tab );

			$this->assertInstanceOf( 'WP_Error', $result );
			$this->assertEquals( $tab, $result->get_error_data() );

		}
		
		/**
		 * @covers ::get_help_tabs
		 */
		public function testMethodGetHelpTabs() {

			$this->assertTrue( method_exists( $this->model, 'get_help_tabs' ) );
			
			$this->setReflectionPropertyValue( $this->model, 'help_tabs', array( 'foo' => 1 , 'bar' => 2 ) );
			
			$this->assertEquals( 
				array( 'foo' => 1, 'bar' => 2 ),
				$this->model->get_help_tabs()
			);

		}
		
		/**
		 * @covers ::get_help_tabs
		 */
		public function testMethodGetHelpTabsEmpty() {

			$this->assertTrue( method_exists( $this->model, 'get_help_tabs' ) );
			$this->assertEmpty( $this->model->get_help_tabs() );

		}
		
		/**
		 * @covers ::add_shortcode
		 */
		public function testMethodAddShortcode() {

			$this->assertClassHasAttribute( 'shortcodes', 'WPMVCB_Model_Base' );
			$this->assertTrue( method_exists( $this->model, 'add_shortcode' ) );
			
			$this->assertTrue( $this->model->add_shortcode( 'foo', array( &$this, 'testMethodGetHelpTabs' ) ) );

		}
		
		/**
		 * @covers ::add_shortcode
		 */
		public function testMethodAddShortcodeFail() {

			$this->assertTrue( method_exists( $this->model, 'add_shortcode' ) );

			$result = $this->model->add_shortcode( 'fooshortcode', 'foocallback' );

			$this->assertInstanceOf( 'WP_Error', $result );
			$this->assertEquals( 'foocallback', $result->get_error_data() );

		}
		
		/**
		 * @covers ::get_shortcodes
		 */
		public function testMethodGetShortcodes() {

			$this->assertTrue( method_exists( $this->model, 'get_shortcodes' ) );
			$this->setReflectionPropertyValue(
				$this->model,
				'shortcodes',
				array('fooshortcode' => array( &$this, 'testMethodAddShortcode' ) ) 
			);
			
			$this->assertEquals( array( 'fooshortcode' => array( &$this, 'testMethodAddShortcode' ) ), $this->model->get_shortcodes() );

		}
		
		/**
		 * @covers ::get_shortcodes
		 */
		public function testMethodGetShortcodesEmpty() {

			$this->assertTrue( method_exists( $this->model, 'get_shortcodes' ) );
			$this->assertEmpty( $this->model->get_shortcodes() );

		}
		
		/**
		 * @covers ::authenticate_post
		 */
		public function testMethodAuthenticatePostForPost() {

			$this->assertTrue( method_exists( $this->model, 'authenticate_post' ) );
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
				$this->model->authenticate_post(
					$post_id,
					'post',
					array( 'foo_name' => wp_create_nonce( 'foo_action' ) ),
					'foo_name',
					'foo_action'
				)
			);

		}

		/**
		 * @covers ::authenticate_post
		 */
		public function testMethodAuthenticatePostForPage() {

			$this->assertTrue( method_exists( $this->model, 'authenticate_post' ) );
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
				$this->model->authenticate_post(
					$post_id,
					'page',
					array( 'foo_name' => wp_create_nonce( 'foo_action' ) ),
					'foo_name',
					'foo_action'
				)
			);

		}

		/**
		 * @covers ::authenticate_post
		 */
		public function testMethodAuthenticatePostUserCannotEditPage() {

			$this->assertTrue( method_exists( $this->model, 'authenticate_post' ) );
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
				$this->model->authenticate_post(
					$post_id,
					'page',
					array( 'foo_name' => wp_create_nonce( 'foo_action' ) ),
					'foo_name',
					'foo_action'
				)
			);

		}

		/**
		 * @covers ::authenticate_post
		 */
		public function testMethodAuthenticatePostUserCannotEditPost() {

			$this->assertTrue( method_exists( $this->model, 'authenticate_post' ) );
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
				$this->model->authenticate_post(
					$post_id,
					'post',
					array( 'foo_name' => wp_create_nonce( 'foo_action' ) ),
					'foo_name',
					'foo_action'
				)
			);

		}

		/**
		 * @covers ::authenticate_post
		 */
		public function testMethodAuthenticatePostNoNonce() {

			$this->assertTrue( method_exists( $this->model, 'authenticate_post' ) );

			$post_id = $this->factory->post->create(
				array(
					'post_title' => 'Test Post',
					'post_type' => 'page',
					'post_status' => 'publish'
				)
			);

			wp_set_current_user( 1 );

			$this->assertEmpty(
				$this->model->authenticate_post(
					$post_id,
					'page',
					array(),
					'foo_name',
					'foo_action'
				)
			);

		}

		/**
		 * @covers ::authenticate_post
		 */
		public function testMethodAuthenticatePostDoingAutosave() {

			$this->assertTrue( method_exists( $this->model, 'authenticate_post' ) );

            $post_id = $this->factory->post->create(
                array(
                    'post_title' => 'Test Post',
                    'post_type' => 'page',
                    'post_status' => 'publish'
                )
            );

			define( 'DOING_AUTOSAVE', true );

			$this->assertEmpty(
				$this->model->authenticate_post(
					$post_id,
					'page',
					array( 'foo_name' => wp_create_nonce( 'foo_action' ) ),
					'foo_name',
					'foo_action'
				)
			);

		}
		
		/**
		 * @covers ::get_admin_notices
		 */
		public function testMethodGetAdminNotices() {

			$this->setReflectionPropertyValue( $this->model, 'admin_notices', array( 'foo', 'bar' ) );
			
			$this->assertTrue( method_exists( 'WPMVCB_Model_Base', 'get_admin_notices' ) );
			$this->assertEquals( array( 'foo', 'bar' ), $this->model->get_admin_notices() );

		}
		
		/**
		 * @covers ::get_admin_notices
		 */
		public function testMethodGetAdminNoticesEmpty() {

			$this->assertTrue( method_exists( 'WPMVCB_Model_Base', 'get_admin_notices' ), 'Method get_admin_notices does not exist' );
			$this->assertEmpty( $this->model->get_admin_notices() );

		}

	}

    class Stub_Base_Model extends WPMVCB_Model_Base {

        protected function init() {

            //implemented, but does nothing

        }

    }

}
