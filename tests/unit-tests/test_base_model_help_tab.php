<?php
namespace WPMVCB\Testing
{
	require_once( WPMVCB_SRC_DIR . '/models/class-base-model-help-tab.php' );
	
	class testBaseModelHelpTab extends WPMVCB_Test_Case
	{
		private $tab;
		
		public function setUp()
		{
			parent::setUp();
			$this->tab = new \Base_Model_Help_Tab(
				'My Test Tab',
				'test-tab',
				'Here is some test tab content',
				array( &$this, 'help_tab_callback' )
			);
		}
		
		public function mock_callback()
		{
			//implemented, but does nothing
		}
		
		public function testMissingParamsError()
		{
			$this->setExpectedException( 'PHPUnit_Framework_Error' );
			$tab = new \Base_Model_Help_Tab( 'Empty Tab', 'empty-tab' );
		}
		
		public function testMissingParamsMessage()
		{
			@$tab = new \Base_Model_Help_Tab( 'Empty Tab', 'empty-tab' );
			$error = error_get_last();
			
			$this->assertEquals(
				'You must specify either the help tab content, a callback function, or a view to use for the help tab', 
				$error['message']
			);
		}
		
		public function testAttributeIdExists()
		{
			$this->assertClassHasAttribute( 'id', 'Base_Model_Help_Tab' );
		}
		
		public function testAttributeTitleExists()
		{
			$this->assertClassHasAttribute( 'title', 'Base_Model_Help_Tab' );
		}
		
		public function testAttributeContentExists()
		{
			$this->assertClassHasAttribute( 'content', 'Base_Model_Help_Tab' );
		}
		
		public function testAttributeCallbackExists()
		{
			$this->assertClassHasAttribute( 'callback', 'Base_Model_Help_Tab' );
		}
		
		public function testAttributeViewExists()
		{
			$this->assertClassHasAttribute( 'view', 'Base_Model_Help_Tab' );
		}
		
		public function testMethodGetId()
		{
			$this->assertTrue( method_exists( 'Base_Model_Help_Tab', 'get_id' ) );
			$this->assertEquals( 'test-tab', $this->tab->get_id() );
		}
		
		public function testMethodGetTitle()
		{
			$this->assertTrue( method_exists( 'Base_Model_Help_Tab', 'get_title' ) );
			$this->assertEquals( 'My Test Tab', $this->tab->get_title() );
		}
		
		public function testMethodSetCallbackExists()
		{
			$this->assertTrue( method_exists( 'Base_Model_Help_Tab', 'set_callback' ) );
		}
		
		/**
		 * @depends testMethodSetCallbackExists
		 */
		public function testMethodSetCallbackError()
		{
			$this->setExpectedException( 'PHPUnit_Framework_Error' );
			$this->tab->set_callback( 'foo' );
		}
		
		/**
		 * @depends testMethodSetCallbackExists
		 */
		public function testSetCallbackMessage()
		{
			@$this->tab->set_callback( 'foo' );
			$error = error_get_last();
			$this->assertEquals( 'A valid callback function must be specified', $error['message'] );
		}
		
		/**
		 * @depends testMethodSetCallbackExists
		 */
		public function testSetCallback()
		{
			$this->assertTrue( $this->tab->set_callback( array( &$this, 'mock_callback' ) ) );
			$this->assertEquals( array( &$this, 'mock_callback' ), $this->getReflectionPropertyValue( $this->tab, 'callback' ) );
		}
		
		public function testMethodSetContent()
		{
			$this->assertTrue( method_exists( 'Base_Model_Help_Tab', 'set_content' ) );
			
			$this->tab->set_content( 'foo' );
			$this->assertEquals( 'foo', $this->getReflectionPropertyValue( $this->tab, 'content' ) );
		}
		
		public function testAdd()
		{
			$this->markTestIncomplete( 'This test not yet implemented' );
		}
	}
}