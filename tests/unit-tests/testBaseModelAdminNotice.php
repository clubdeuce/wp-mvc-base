<?php
namespace WPMVCB\Testing\UnitTests {

	use \WPMVCB\Testing\WPMVCB_Test_Case;
	use \WPMVCB_Admin_Notice_Model_Base;

	/**
	 * The tests for WPMVCB_Admin_Notice_Model_Base
	 *
	 * @group     AdminNotices
	 * @covers    WPMVCB_Admin_Notice_Model_Base
	 * @since WPMVCBase 0.1
	 * @internal
	 */

	class testBaseModelAdminNotice extends WPMVCB_Test_Case {

		/**
		 * @var WPMVCB_Admin_Notice_Model_Base
		 */
		private $admin_notice;

		public function setUp() {

			$this->admin_notice = new \WPMVCB_Admin_Notice_Model_Base( array(
				'type'    => 'updated',
				'message' => 'foo message',
				'screens' => array( 'post' ),
			) );

		}
		
		public function tearDown() {

			unset( $this->admin_notice );

		}
		
		public function testPropertyExistsType() {

			$this->assertClassHasAttribute( 'type', 'WPMVCB_Admin_Notice_Model_Base' );

		}
		
		public function testPropertyExistsMessage() {

			$this->assertClassHasAttribute( 'message', 'WPMVCB_Admin_Notice_Model_Base' );

		}
		
		public function testPropertyExistsScreens() {

			$this->assertClassHasAttribute( 'screens', 'WPMVCB_Admin_Notice_Model_Base' );

		}
		
		/**
		 * @covers ::get_type
		 */
		public function testMethodGetType() {

			$this->assertTrue( method_exists( 'WPMVCB_Admin_Notice_Model_Base', 'get_type' ), 'Method get_type does not exist' );
			$this->assertEquals( 'updated', $this->admin_notice->get_type() );

		}
		
		/**
		 * @covers ::get_message
		 */
		public function testMethodGetMessage() {

			$this->assertTrue( method_exists( 'WPMVCB_Admin_Notice_Model_Base', 'get_message' ), 'Method get_message does not exist' );
			$this->assertEquals( 'foo message', $this->admin_notice->get_message() );

		}
		
		/**
		 * @covers ::get_screens
		 */
		public function testMethodGetScreens() {

			$this->assertTrue( method_exists( 'WPMVCB_Admin_Notice_Model_Base', 'get_screens' ), 'Method get_screens does not exist' );
			$this->assertEquals( array( 'post' ), $this->admin_notice->get_screens() );

		}
		
		/**
		 * @covers ::get_screens
		 */
		public function testMethodGetScreensEmptyScreens() {

			$this->assertTrue( method_exists( 'WPMVCB_Admin_Notice_Model_Base', 'get_screens' ), 'Method get_screens does not exist' );
			
			$notice = new \WPMVCB_Admin_Notice_Model_Base();
			$this->assertEmpty( $notice->get_screens() );

		}

	}

}
