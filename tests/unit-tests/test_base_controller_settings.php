<?php
namespace WPMVCB\Testing
{
	require_once WPMVCB_SRC_DIR . '/controllers/class-base-controller-settings.php';
	require_once WPMVCB_SRC_DIR . '/models/class-base-model-settings.php';
	/**
	 * The test controller for Base_Controller_Plugin
	 *
	 * @since WPMVCBase 0.1
	 * @internal
	 */
	 
	class BaseControllerSettingsTest extends WPMVCB_Test_Case
	{
		public function setUp()
		{
			parent::setUp();
			
			$this->_model = $this
				->getMockBuilder( '\Base_Model_Settings' )
				->disableOriginalConstructor()
				->setMethods( 
					array(
						'get_settings_sections',
						'get_settings_fields',
						'get_options',
						'get_pages'
					)
				)
				->getMockForAbstractClass();
				
			$this->_controller = $this
				->getMockBuilder( '\Base_Controller_Settings' )
				->setConstructorArgs( array( $this->_model ) )
				->setMethods( null )
				->getMock();
		}
		
		public function tearDown()
		{
			remove_action( 'admin_init', array( $this->_controller, 'add_settings_sections' ) );
			remove_action( 'admin_init', array( $this->_controller, 'add_settings_fields' ) );
			remove_action( 'admin_init', array( $this->_controller, 'register_options' ) );
			remove_action( 'admin_menu', array( $this->_controller, 'add_menu_pages' ) );
			unset( $this->_model );
			unset( $this->_controller );
		}
		
		/**
		 * Tear down a fixture.
		 *
		 * @param object $object The fixture object.
		 * @since 0.2
		 */
		private function _tearDown( $object )
		{
			remove_action( 'admin_init', array( $object, 'add_settings_sections' ) );
			remove_action( 'admin_init', array( $object, 'add_settings_fields' ) );
			remove_action( 'admin_init', array( $object, 'register_options' ) );
			remove_action( 'admin_menu', array( $object, 'add_menu_pages' ) );
			unset( $object );
		}
		
		private function _mockFilesystem()
		{
			//set up our virtual filesystem
			\org\bovigo\vfs\vfsStreamWrapper::register();
			\org\bovigo\vfs\vfsStreamWrapper::setRoot( new \org\bovigo\vfs\vfsStreamDirectory( 'test_dir' ) );
			$this->_mock_path = trailingslashit( \org\bovigo\vfs\vfsStream::url( 'test_dir' ) );
			$this->_filesystem = \org\bovigo\vfs\vfsStreamWrapper::getRoot();
		}
		
		public function testAttibuteExistsModel()
		{
			$this->assertClassHasAttribute( 'model', '\Base_Controller_Settings' );
		}
		
		public function testMethodConstructSetModel()
		{
			$controller = new \Base_Controller_Settings( $this->_model );
			$this->assertSame( $this->_model, $this->getReflectionPropertyValue( $controller, 'model' ) );
			$this->_tearDown( $controller );
		}
		
		/**
		 * @expectedException PHPUnit_Framework_Error
		 * @expectedExceptionMessage __construct expects an object of type Base_Model_Settings
		 */
		public function testMethodConstructFail()
		{
			$model = new \stdClass;
			
			$controller = $this
				->getMockBuilder( '\Base_Controller_Settings' )
				->setConstructorArgs( array( $model ) )
				->getMock();
				
			$this->_tearDown( $controller );
		}
		
		public function testActionExistsAdminInitAddSettingsSections()
		{
			$this->_model
				->expects( $this->any() )
				->method( 'get_settings_sections' )
				->will( $this->returnValue( array() ) );
				
			$controller = new \Base_Controller_Settings( $this->_model );
			$this->assertFalse( false === has_action( 'admin_init', array( $controller, 'add_settings_sections' ) ) );
			$this->_tearDown( $controller );
		}
		
		public function testActionExistsAdminInitAddSettingsFields()
		{
			$this->_model
				->expects( $this->any() )
				->method( 'get_settings_fields' )
				->will( $this->returnValue( array() ) );
				
			$controller = new \Base_Controller_Settings( $this->_model );
			$this->assertFalse( false === has_action( 'admin_init', array( $controller, 'add_settings_fields' ) ) );
			$this->_tearDown( $controller );
		}
		
		public function testActionExistsAdminInitRegisterOptions()
		{
			$this->_model
				->expects( $this->any() )
				->method( 'get_options' )
				->will( $this->returnValue( array() ) );
				
			$controller = new \Base_Controller_Settings( $this->_model );
			$this->assertFalse( false === has_action( 'admin_init', array( $controller, 'register_options' ) ) );
			$this->_tearDown( $controller );
		}
		
		public function testActionExistsAdminMenuAddMenuPages()
		{
			$this->_model
				->expects( $this->any() )
				->method( 'get_pages' )
				->will( $this->returnValue( array() ) );
				
			$controller = new \Base_Controller_Settings( $this->_model );
			$this->assertFalse( false === has_action( 'admin_menu', array( $controller, 'add_menu_pages' ) ) );
			$this->_tearDown( $controller );
		}
		
		/**
		 * Test method register_options().
		 *
		 * This test is subject to breaking as it uses WP internals. Ideally, a better solution should be found.
		 * @covers Base_Controller_Settings::register_options
		 */
		public function testMethodRegisterOptions()
		{
			global $new_whitelist_options;
			
			$this->_model
				->expects( $this->any() )
				->method( 'get_options' )
				->will( $this->returnValue( array( 'foo' => array( 'option_group' => 'bar', 'option_name' => 'baz' ) ) ) );
				
			$controller = new \Base_Controller_Settings( $this->_model );
			$this->assertTrue( method_exists( $controller, 'register_options' ) );
			$controller->register_options();

			$this->assertArrayHasKey( 'bar', $new_whitelist_options );
			$this->assertSame( array( 'baz' ), $new_whitelist_options['bar'] );
			$this->_tearDown( $controller );
		}
		
		/**
		 * @uses $wp_settings_sections
		 * @covers Base_Controller_Settings::add_settings_sections
		 */
		public function testMethodAddSettingsSections()
		{
			global $wp_settings_sections;
			
			$this->assertTrue( method_exists( $this->_controller, 'add_settings_sections' ) );
			
			//set up a settings section
			$section = array(
				'foosection' => array(
					'title'    => 'Foo Section Title',
					'callback' => null,
					'page'     => 'foopage',
					'content'  => 'Foo content'
				)
			);
			
			//set up the stub settings model
			$this->_model
				->expects( $this->any() )
				->method( 'get_settings_sections' )
				->will( $this->returnValue( $section ) );
				
			//create a new controller
			$controller = new \Base_Controller_Settings( $this->_model );
			$controller->add_settings_sections();
			
			$this->assertArrayHasKey( 'foopage', $wp_settings_sections );
			$this->assertArrayHasKey( 'foosection', $wp_settings_sections['foopage'] );
			$this->assertSame( 'foosection', $wp_settings_sections['foopage']['foosection']['id'] );
			$this->assertSame( 'Foo Section Title', $wp_settings_sections['foopage']['foosection']['title'] );
			$this->assertSame( 
				array( $controller, 'render_settings_section' ),
				$wp_settings_sections['foopage']['foosection']['callback']
			);
			
			$this->_tearDown( $controller );
		}
		
		/**
		 * @uses $wp_settings_fields
		 * @covers Base_Controller_Settings::add_settings_fields
		 */
		public function testMethodAddSettingsFields()
		{
			global $wp_settings_fields;
			
			$this->assertTrue( method_exists( $this->_controller, 'add_settings_fields' ) );
			
			$fields = array(
				'foofield' => array(
					'title' => 'Foo Field',
					'callback' => null,
					'page'     => 'foopage',
					'section'  => 'foosection',
					'args'     => array( 'bar', 'baz' )
				)
			);
			
			$this->_model
				->expects( $this->any() )
				->method( 'get_settings_fields' )
				->will( $this->returnValue( $fields ) );
			
			$controller = new \Base_Controller_Settings( $this->_model );
			$controller->add_settings_fields();
			
			$this->assertArrayHasKey( 'foopage', $wp_settings_fields );
			$this->assertArrayHasKey( 'foosection', $wp_settings_fields['foopage'] );
			$this->assertArrayHasKey( 'foofield', $wp_settings_fields['foopage']['foosection'] );
			$this->assertSame( 'foofield', $wp_settings_fields['foopage']['foosection']['foofield']['id'] );
			$this->assertSame( 'Foo Field', $wp_settings_fields['foopage']['foosection']['foofield']['title'] );
			$this->assertSame( 
				array( $controller, 'render_settings_field' ),
				$wp_settings_fields['foopage']['foosection']['foofield']['callback']
			);
			$this->assertSame(
				array( 'bar', 'baz' ),
				$wp_settings_fields['foopage']['foosection']['foofield']['args']
			);
		}
		
		/**
		 * @covers Base_Controller_Settings::add_menu_pages
		 */
		public function testMethodAddMenuPagesMenu()
		{
			$this->assertTrue( method_exists( $this->_controller, 'add_menu_pages' ) );
			
			//set up a page object stub
			require_once WPMVCB_SRC_DIR . '/models/class-base-model-menu-page.php';
			
			$page = new \Base_Model_Menu_Page();
			$this->setReflectionPropertyValue( $page, '_page_title', 'foo_title' );
			$this->setReflectionPropertyValue( $page, '_menu_title', 'Foo Title' );
			$this->setReflectionPropertyValue( $page, '_capability', 'manage_options' );
			$this->setReflectionPropertyValue( $page, '_menu_slug', 'foo-slug' );
			
			//set up the model
			$this->_model
				->expects( $this->any() )
				->method( 'get_pages' )
				->will( $this->returnValue( array( 0 => $page ) ) );
				
			//add the page to the model
			$this->setReflectionPropertyValue( $this->_model, 'pages', array( 'foo-page' => $page ) );
			
			//create the settings controller
			$controller = new \Base_Controller_Settings( $this->_model );
			$controller->add_menu_pages();
			
			//get a reflection of the model pages property
			$model = $this->getReflectionPropertyValue( $controller, 'model' );
			$pages = $this->getReflectionPropertyValue( $model, 'pages' );
			
			$this->assertArrayHasKey( 'foo-page', $pages );
			$this->assertEquals( 'toplevel_page_foo-slug', $this->getReflectionPropertyValue( $pages['foo-page'], '_hook_suffix' ) );
			$this->_tearDown( $controller );
		}
		
		/**
		 * @covers Base_Controller_Settings::add_menu_pages
		 */
		public function testMethodAddMenuPagesMenuError()
		{
			$this->markTestIncomplete( 'Not yet complete' );
			$this->assertTrue( method_exists( $this->_controller, 'add_menu_pages' ) );
			
			//set up a page object stub
			require_once WPMVCB_SRC_DIR . '/models/class-base-model-menu-page.php';
			
			$page = new \Base_Model_Menu_Page();
			$this->setReflectionPropertyValue( $page, '_parent_slug', 'general' );
			$this->setReflectionPropertyValue( $page, '_page_title', 'foo_title' );
			$this->setReflectionPropertyValue( $page, '_menu_title', 'Foo Title' );
			$this->setReflectionPropertyValue( $page, '_capability', 'foo_capability' );
			$this->setReflectionPropertyValue( $page, '_menu_slug', 'foo-slug' );
			
			//set up the model
			$this->_model
				->expects( $this->any() )
				->method( 'get_pages' )
				->will( $this->returnValue( array( 0 => $page ) ) );
				
			//add the page to the model
			$this->setReflectionPropertyValue( $this->_model, 'pages', array( 'foo-page' => $page ) );
			
			$this->setExpectedException( 'PHPUnit_Framework_Error', 'Unable to add submenu page due to insufficient user capability: 0' );
			
			//create the settings controller
			$controller = new \Base_Controller_Settings( $this->_model );
			$controller->add_menu_pages();
			
			$this->_tearDown( $controller );
		}
		
		public function testMethodExistsRenderOptionsPage()
		{
			$this->assertTrue( method_exists( $this->_controller, 'render_options_page' ) );
		}
		
		/**
		 * Ensure the default options page view exists and is used on non-existent view.
		 * 
		 * @depends testMethodExistsRenderOptionsPage
		 * @covers Base_Controller_Settings::render_options_page
		 */
		public function testMethodRenderOptionsPageNoView()
		{	
			set_current_screen( 'foopage' );
			$pages = array( 'foopage' => array( 'view' => 'fooview.php' ) );
			
			$this->_model
				->expects( $this->any() )
				->method( 'get_pages' )
				->will( $this->returnValue( $pages ) );
			
			$controller = new \Base_Controller_Settings( $this->_model );
			$this->assertFileExists( WPMVCB_SRC_DIR . '/views/base_options_page.php' );
			
			ob_start();
			include WPMVCB_SRC_DIR . '/views/base_options_page.php';
			$expected = ob_get_clean();
			
			ob_start();
			$controller->render_options_page();
			$output = ob_get_clean();
			
			//$this->assertSame( $expected, $output );
			$this->assertSame( $expected, $output );
			
			$this->_tearDown( $controller );
		}
		
		/**
		 * @depends testMethodExistsRenderOptionsPage
		 * @covers Base_Controller_Settings::render_options_page
		 * @requires set_current_screen
		 */
		public function testMethodRenderOptionsPageViewExists()
		{
			//set up mock filesystem
			$this->_mockFilesystem();
			
			//create a mock view file
			$handle = fopen( $this->_mock_path . '/view.php', 'w' );
			fwrite($handle, 'foobar');
			fclose( $handle );
			$this->assertTrue( $this->_filesystem->hasChild( 'view.php' ) );
			
			//set the WP_Screen object
			set_current_screen( 'foopage' );
						
			//set up a page object
			$pages = array( 
				'foopage' => array( 
					'view' => $this->_mock_path . '/view.php'
				)
			);
			
			//set up the settings model stub
			$this->_model
				->expects( $this->any() )
				->method( 'get_pages' )
				->will( $this->returnValue( $pages ) );
			
			$controller = new \Base_Controller_Settings( $this->_model );
			
			//get the actual output
			ob_start();
			$controller->render_options_page();
			$output = ob_get_clean();
			
			//assert they are the same
			$this->assertSame( 'foobar', $output );
			$this->_tearDown( $controller );
		}
		
		public function testMethodExistsRenderSettingsSection()
		{
			$this->assertTrue( method_exists( $this->_controller, 'render_settings_section' ) );
		}
		
		/**
		 * @covers Base_Controller_Settings::render_settings_section
		 * @depends testMethodExistsRenderSettingsSection
		 */
		public function testMethodRenderSettingsSectionViewNonExistent()
		{
			//set up a settings section
			$section = array(
				'title'    => 'Foo Section Title',
				'callback' => null,
				'page'     => 'foopage',
				'content'  => 'Foo content'
			);
			
			//set up the stub settings model
			$this->_model
				->expects( $this->any() )
				->method( 'get_settings_sections' )
				->will( $this->returnValue( $section ) );
				
			//create a new controller
			$controller = new \Base_Controller_Settings( $this->_model );
			
			ob_start();
			$controller->render_settings_section( array( 'id' => 'foosection' ) );
			$output = ob_get_clean();
			
			$this->assertSame( 'Foo content', $output );
			$this->_tearDown( $controller );
		}
		
		/**
		 * @covers Base_Controller_Settings::render_settings_section
		 * @depends testMethodExistsRenderSettingsSection
		 */
		public function testMethodRenderSettingsSectionViewExists()
		{
			//set up our virtual filesystem
			\org\bovigo\vfs\vfsStreamWrapper::register();
			\org\bovigo\vfs\vfsStreamWrapper::setRoot( new \org\bovigo\vfs\vfsStreamDirectory( 'test_dir' ) );
			$this->_mock_path = trailingslashit( \org\bovigo\vfs\vfsStream::url( 'test_dir' ) );
			$this->_filesystem = \org\bovigo\vfs\vfsStreamWrapper::getRoot();
			
			//set up a view file
			$this->_mockFilesystem();
			$handle = fopen( $this->_mock_path . '/view.php', 'w' );
			fwrite($handle, 'foobar');
			fclose( $handle );
			$this->assertTrue( $this->_filesystem->hasChild( 'view.php' ) );
			
			//set up a settings section
			$section =  array(
				'title'    => 'Foo Section Title',
				'callback' => null,
				'page'     => 'foopage',
				'content'  => 'Foo content',
				'view'     => $this->_mock_path . '/view.php'
			);
			
			//set up the stub settings model
			$this->_model
				->expects( $this->any() )
				->method( 'get_settings_sections' )
				->will( $this->returnValue( $section ) );
				
			//create a new controller
			$controller = new \Base_Controller_Settings( $this->_model );
			
			//get the expected output
			ob_start();
			include $this->_mock_path . '/view.php';
			$expected = ob_get_clean();
			
			ob_start();
			$controller->render_settings_section( array( 'id' => 'foosection' ) );
			$output = ob_get_clean();
			
			$this->assertSame( $expected, $output );
			unset( $this->_mock_path );
			unset( $this->_filesystem );
			$this->_tearDown( $controller );
		}
		
		public function testMethodExistsRenderSettingsField()
		{
			$this->assertTrue( method_exists( $this->_controller, 'render_settings_field' ) );
		}
		
		/**
		 * Test render_settings_field response when call lacks required parameters type, id, and/or name
		 * @depends testMethodExistsRenderSettingsField
		 * @covers Base_Controller_Settings::render_settings_field
		 * @expectedException PHPUnit_Framework_Error
		 * @expectedErrorMessage The settings field type, id and name must be set
		 */
		public function testMethodFailRenderSettingsFieldNoType()
		{
			$this->_controller->render_settings_field( array( 'type' => null, 'id' => 'bar', 'name' => 'baz' ) );
		}
		
		/**
		 * Test render_settings_field response when call lacks required parameters type, id, and/or name
		 * @depends testMethodExistsRenderSettingsField
		 * @covers Base_Controller_Settings::render_settings_field
		 * @expectedException PHPUnit_Framework_Error
		 * @expectedErrorMessage The settings field type, id and name must be set
		 */
		public function testMethodFailRenderSettingsFieldNoId()
		{
			$this->_controller->render_settings_field( array( 'type' => 'foo', 'id' => null, 'name' => 'baz' ) );
		}
		
		/**
		 * Test render_settings_field response when call lacks required parameters type, id, and/or name
		 * @depends testMethodExistsRenderSettingsField
		 * @covers Base_Controller_Settings::render_settings_field
		 * @expectedException PHPUnit_Framework_Error
		 * @expectedErrorMessage The settings field type, id and name must be set
		 */
		public function testMethodFailRenderSettingsFieldNoName()
		{
			$this->_controller->render_settings_field( array( 'type' => 'foo', 'id' => 'bar', 'name' => null ) );
		}
		
		/**
		 * Test render_settings_field response when rendering select field with no options
		 * @depends testMethodExistsRenderSettingsField
		 * @covers Base_Controller_Settings::render_settings_field
		 * @expectedException PHPUnit_Framework_Error
		 * @expectedErrorMessage The settings field type, id and name must be set
		 */
		public function testMethodRenderSettingsFieldFailNoOptions()
		{
			$field = array(
				'type'		=> 'select',
				'id'		=> 'my-super-cool-select',
				'name'		=> 'my_super_cool_select',
				'value'		=> 'my-super-cool-value',
			);
			
			$this->_controller->render_settings_field( $field );
		}
		
		/**
		 * @depends testMethodExistsRenderSettingsField
		 * @covers Base_Controller_Settings::render_settings_field
		 */
		public function testMethodRenderInputText()
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
		
		/**
		 * @depends testMethodExistsRenderSettingsField
		 * @covers Base_Controller_Settings::render_settings_field
		 */
		public function testMethodReturnInputText()
		{	
			$this->_mockFilesystem();
			$handle = fopen( $this->_mock_path . '/view.php', 'w' );
			fwrite($handle, 'foobar');
			fclose( $handle );
			$this->assertTrue( $this->_filesystem->hasChild( 'view.php' ) );
			
			$field = array(
				'type' => 'text',
				'id' => 'my-super-cool-field',
				'name' => 'my_super_cool_field',
				'value' => 'foo',
				'placeholder' => 'Enter some value',
				'after' => $this->_mock_path . '/view.php'
			);
			
			$expected = '<input type="text" id="my-super-cool-field" name="my_super_cool_field" value="foo" placeholder="Enter some value" />foobar';
			
			$this->assertSame( $expected, $this->_controller->render_settings_field( $field, 'noecho' ) );
		}
		
		/**
		 * @depends testMethodExistsRenderSettingsField
		 * @covers Base_Controller_Settings::render_settings_field
		 */
		public function testMethodRenderInputCheckbox()
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
		
		/**
		 * @depends testMethodExistsRenderSettingsField
		 * @covers Base_Controller_Settings::render_settings_field
		 */
		public function testMethodReturnInputCheckbox()
		{
			$field = array(
				'type'	=> 'checkbox',
				'id'	=> 'my-super-cool-checkbox',
				'name'	=> 'my_super_cool_checkbox',
				'value'	=> '0'
			);
			
			$expected = '<input type="checkbox" id="my-super-cool-checkbox" name="my_super_cool_checkbox" value="1" />';
			
			$this->assertSame( $expected, $this->_controller->render_settings_field( $field, 'noecho' ) );
		}
		
		/**
		 * @depends testMethodExistsRenderSettingsField
		 * @covers Base_Controller_Settings::render_settings_field
		 */
		public function testMethodRenderInputCheckboxChecked()
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
		
		/**
		 * @depends testMethodExistsRenderSettingsField
		 * @covers Base_Controller_Settings::render_settings_field
		 */
		public function testMethodReturnInputCheckboxChecked()
		{
			$field = array(
				'type'	=> 'checkbox',
				'id'	=> 'my-super-cool-checkbox',
				'name'	=> 'my_super_cool_checkbox',
				'value'	=> '1',
			);
			
			$expected = '<input type="checkbox" id="my-super-cool-checkbox" name="my_super_cool_checkbox" value="1" checked />';
			
			$this->assertSame( $expected, $this->_controller->render_settings_field( $field, 'noecho' ) );
		}
		
		/**
		 * @depends testMethodExistsRenderSettingsField
		 * @covers Base_Controller_Settings::render_settings_field
		 */
		public function testMethodRenderInputSelect()
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
		
		/**
		 * @depends testMethodExistsRenderSettingsField
		 * @covers Base_Controller_Settings::render_settings_field
		 */
		public function testMethodReturnInputSelect()
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
			
			$this->assertSame( $expected, $this->_controller->render_settings_field( $field, 'noecho' ) );
		}
		
		/**
		 * @depends testMethodExistsRenderSettingsField
		 * @covers Base_Controller_Settings::render_settings_field
		 */
		public function testMethodRenderTextarea()
		{
			$field = array(
				'type'		=> 'textarea',
				'id'		=> 'my-super-cool-textarea',
				'name'		=> 'my_super_cool_textarea',
				'value'		=> 'My textarea content'
			);
			$expected = '<textarea id="my-super-cool-textarea" name="my_super_cool_textarea" >My textarea content</textarea>';
			$this->expectOutputString( $expected );
			$this->_controller->render_settings_field( $field, 'echo' );
		}
		
		/**
		 * @depends testMethodExistsRenderSettingsField
		 * @covers Base_Controller_Settings::render_settings_field
		 */
		public function testMethodReturnTextarea()
		{
			$field = array(
				'type'		=> 'textarea',
				'id'		=> 'my-super-cool-textarea',
				'name'		=> 'my_super_cool_textarea',
				'value'		=> 'My textarea content'
			);
			$expected = '<textarea id="my-super-cool-textarea" name="my_super_cool_textarea" >My textarea content</textarea>';
			$this->assertSame( $expected, $this->_controller->render_settings_field( $field, 'noecho' ) );
		}
	}
}