<?php
namespace WPMVCBase\Testing
{
	require_once( dirname( __FILE__ ) . '../../../controllers/base_controller_plugin.php' );
	require_once( dirname( __FILE__ ) . '../../../models/base_model_cpt.php' );
	
	/**
	 * The stub CPT for the controller tests
	 *
	 * @package WPMVCBase_Testing\Unit_Tests
	 * @since 0.2
	 * @internal
	 */
	class Test_Stub_CPT extends \Base_Model_CPT
	{
		protected $slug = 'my-test-cpt';
		
		public $help_tabs = array();
		
		public function save_post()
		{
			//implemented, but does nothing
		}
		
		public function the_post( $post )
		{
			$post->foo = 'bar';
			return $post;
		}
		
		public function delete_post()
		{
			//implemented, but does nothing
		}
	}
	
	/**
	 * The settings model test stub
	 *
	 * @package WPMVCBase_Testing\Unit_Tests
	 * @since WPMVCBase 0.2
	 * @internal
	 */
	class Test_Stub_Settings_Model
	{
		public function get_pages()
		{
		}
		
		public function get_settings_sections( $id )
		{
			return array(
				
			);
		}
	}
	
	
	/**
	 * The stub controller for phpUnit tests.
	 *
	 * @package WPMVCBase_Testing\Unit_Tests
	 * @since WPMVCBase 0.1
	 * @internal
	 */
	class WPMVCB_Controller extends \Base_Controller_Plugin {
		public function init()
		{
			$cpt = new Test_Stub_CPT( 'http://example.com', 'my-txtdomain' );
			$this->add_cpt( $cpt );
		}
		
		public function get_cpt()
		{
			return $this->cpts[ 'my-test-cpt'];
		}
	}
	
	/**
	 * The test controller for Base_Controller_Plugin.
	 *
	 * @package WPMVCBase_Testing\Unit_Tests
	 * @since WPMVCBase 0.1
	 * @internal
	 */
	class TestBaseControllerPlugin extends \WP_UnitTestCase
	{
		private $_controller;
		
		public function SetUp()
		{
			$this->_controller = new WPMVCB_Controller(
				'my-super-cool-plugin',
				'1.0',
				'/home/user/public_html/wp-content/plugins/my-super-cool-plugin',
				'/home/user/public_html/wp-content/plugins/my-super-cool-plugin/my-super-cool-plugin.php',
				'http://my-super-cool-domain.com/wp-content/plugins/my-super-cool-plugin',
				'my-super-cool-text-domain'
			);
		}
		
		public function testGetVersion()
		{
			$this->assertEquals( '1.0', $this->_controller->get_version() );
		}
		
		public function testGetSlug()
		{
			$this->assertEquals( 'my-super-cool-plugin', $this->_controller->get_slug() );
		}
		
		public function testGetTextdomain()
		{
			$this->assertEquals( 'my-super-cool-text-domain', $this->_controller->get_textdomain() );
		}
		
		public function testMainPluginFile()
		{
			$this->assertEquals( '/home/user/public_html/wp-content/plugins/my-super-cool-plugin/my-super-cool-plugin.php', $this->_controller->main_plugin_file() );
		}
		
		public function testRenderInputText()
		{
			$field = array(
				'type' => 'text',
				'id' => 'my-super-cool-field',
				'name' => 'my_super_cool_field',
				'value' => 'foo',
				'placeholder' => 'Enter some value',
				'after' => 'bar'
			);
			
			$expected = '<input type="text" id="my-super-cool-field" name="my_super_cool_field" value="foo" placeholder="Enter some value" />bar';
			
			$this->expectOutputString( $expected );
			$this->_controller->render_settings_field( $field );
		}
		
		public function testReturnInputText()
		{
			$field = array(
				'type' => 'text',
				'id' => 'my-super-cool-field',
				'name' => 'my_super_cool_field',
				'value' => 'foo',
				'placeholder' => 'Enter some value',
				'after' => dirname( dirname( __FILE__ ) ) . '/README.md'
			);
			
			$expected = '<input type="text" id="my-super-cool-field" name="my_super_cool_field" value="foo" placeholder="Enter some value" />';
			
			ob_start();
			require_once( dirname( __FILE__ ) . '/../README.md' );
			$expected .= ob_get_clean();
			
			$this->assertEquals( $expected, $this->_controller->render_settings_field( $field, 'noecho' ) );
		}
		
		public function testRenderInputCheckbox()
		{
			$field = array(
				'type'	=> 'checkbox',
				'id'	=> 'my-super-cool-checkbox',
				'name'	=> 'my_super_cool_checkbox',
				'value'	=> '0',
			);
			
			$expected = '<input type="checkbox" id="my-super-cool-checkbox" name="my_super_cool_checkbox" value="1" />';
			
			$this->expectOutputString( $expected );
			$this->_controller->render_settings_field( $field );
		}
		
		public function testReturnInputCheckbox()
		{
			$field = array(
				'type'	=> 'checkbox',
				'id'	=> 'my-super-cool-checkbox',
				'name'	=> 'my_super_cool_checkbox',
				'value'	=> '0',
			);
			
			$expected = '<input type="checkbox" id="my-super-cool-checkbox" name="my_super_cool_checkbox" value="1" />';
			
			$this->assertEquals( $expected, $this->_controller->render_settings_field( $field, 'noecho' ) );
		}
		
		public function testRenderInputCheckboxChecked()
		{
			$field = array(
				'type'	=> 'checkbox',
				'id'	=> 'my-super-cool-checkbox',
				'name'	=> 'my_super_cool_checkbox',
				'value'	=> '1',
			);
			
			$expected = '<input type="checkbox" id="my-super-cool-checkbox" name="my_super_cool_checkbox" value="1" checked />';
			
			$this->expectOutputString( $expected );
			$this->_controller->render_settings_field( $field );
		}
		
		public function testReturnInputCheckboxChecked()
		{
			$field = array(
				'type'	=> 'checkbox',
				'id'	=> 'my-super-cool-checkbox',
				'name'	=> 'my_super_cool_checkbox',
				'value'	=> '1',
			);
			
			$expected = '<input type="checkbox" id="my-super-cool-checkbox" name="my_super_cool_checkbox" value="1" checked />';
			
			$this->assertEquals( $expected, $this->_controller->render_settings_field( $field, 'noecho' ) );
		}
		
		public function testRenderInputSelect()
		{
			$field = array(
				'type'		=> 'select',
				'id'		=> 'my-super-cool-select',
				'name'		=> 'my_super_cool_select',
				'value'		=> 'my-super-cool-value',
				'options'	=> array(
					'my_super_cool_option' => 'My Super Cool Option'
				)
			);
			
			$expected = '<select id="my-super-cool-select" name="my_super_cool_select"><option value="">Select…</option><option value="my_super_cool_option" >My Super Cool Option</option></select>';
			
			$this->expectOutputString( $expected );
			$this->_controller->render_settings_field( $field );
		}
		
		public function testReturnInputSelect()
		{
			$field = array(
				'type'		=> 'select',
				'id'		=> 'my-super-cool-select',
				'name'		=> 'my_super_cool_select',
				'value'		=> 'my-super-cool-value',
				'options'	=> array(
					'my_super_cool_option' => 'My Super Cool Option'
				)
			);
			
			$expected = '<select id="my-super-cool-select" name="my_super_cool_select"><option value="">Select…</option><option value="my_super_cool_option" >My Super Cool Option</option></select>';
			
			$this->assertEquals( $expected, $this->_controller->render_settings_field( $field, 'noecho' ) );
		}
		
		public function test_add_cpt_register()
		{
			$cpt = $this->_controller->get_cpt();
			$this->assertFalse( false === has_action( 'init', array( $cpt, 'register' ) ) );
		}
		
		/*
		 * The following functions use the assertFalse because WP has_action my occasionally
		 * return a non-boolean value that evaluates to false
		 */
		public function test_add_cpt_add_meta_boxes()
		{
			$this->assertFalse( false === has_action( 'add_meta_boxes', array( $this->_controller, 'add_meta_boxes' ) ) );
		}
		
		public function test_add_cpt_add_post_updated_messages()
		{
			$this->assertFalse( false === has_action( 'post_updated_messages', array( $this->_controller, 'post_updated_messages' ) ) );
		}
		
		public function test_add_cpt_add_the_post()
		{
			$this->assertFalse( false === has_action( 'the_post', array( $this->_controller, 'callback_the_post' ) ) );
		}
		
		public function test_add_cpt_add_save_post()
		{
			$this->assertFalse( false === has_action( 'save_post', array( $this->_controller, 'callback_save_post' ) ) );
		}
		
		public function test_add_cpt_add_delete_post()
		{
			$this->assertFalse( false === has_action( 'delete_post', array( $this->_controller, 'callback_delete_post' ) ) );
		}
		
		public function test_add_cpt_help_tabs()
		{
			$this->assertClassHasAttribute( 'help_tabs', '\WPMVCBase\Testing\WPMVCB_Controller' );
		}
	}
}
?>