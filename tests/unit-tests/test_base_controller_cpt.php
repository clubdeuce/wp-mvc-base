<?php
namespace WPMVCB\Testing\UnitTests {

	use \Base_Controller_CPT;
	use \WPMVCB\Testing\WPMVCB_Test_Case;

	require_once WPMVCB_SRC_DIR . '/models/class-base-model-cpt.php';
	require_once WPMVCB_SRC_DIR . '/controllers/class-base-controller.php';
	require_once WPMVCB_SRC_DIR . '/controllers/class-base-controller-cpt.php';

	/**
	 * The test controller for Base_Controller_Plugin.
	 *
	 * @package            WPMVCBase_Testing\Unit_Tests
	 * @group              CPT
	 * @coversDefaultClass Base_Controller_CPT
	 * @since              WPMVCBase 0.1
	 * @internal
	 */
	class testBaseControllerCpt extends WPMVCB_Test_Case {

		/**
		 * The system under test
		 *
		 * @var Base_Controller_CPT
		 */
		private $_controller;

		public function setUp() {

			parent::setUp();
			$this->_controller = new Base_Controller_CPT();

		}

		public function tearDown() {

			unset( $this->_controller );

		}

		private function _createStubCptModel() {

			// Create stub for cpt_model
			$cpt_model = $this->getMockBuilder( '\Base_Model_CPT' )
						 ->disableOriginalConstructor()
						 ->setMethods( 
						 	array( 
						 		'get_slug',
						 		'get_args',
						 		'get_post_updated_messages',
						 		'get_metaboxes',
						 		'get_singular',
						 		'get_plural',
						 		'get_scripts',
						 		'get_admin_scripts',
						 		'save_post'
						 	)
						 )
						 ->getMockForAbstractClass();
			          
			return $cpt_model;

		}
		

		/**
		 * @covers ::post_updated_messages
		 */
		public function testMethodPostUpdatedMessages() {

			$this->assertTrue( method_exists( $this->_controller, 'post_updated_messages' ) );

			register_post_type( 'foocptslug', array( 'labels' => array( 'singular_name' => 'Book' ) ) );

			global $post;

			$post = $this->factory->post->create_and_get( array( 'post_type' => 'foocptslug' ) );

			$messages = $this->_controller->post_updated_messages( array() );
			
			$expected = array(
				0 => null, // Unused. Messages start at index 1.
				1 => sprintf( __('Book updated. <a href="%s">View book</a>', 'wpmvcb'), esc_url( get_permalink( $post->ID) ) ),
				2 => __('Custom field updated.', 'wpmvcb'),
				3 => __('Custom field deleted.', 'wpmvcb'),
				4 => __('Book updated.', 'wpmvcb'),
				/* translators: %s: date and time of the revision */
				5 => isset($_GET['revision']) ? sprintf( __('Book restored to revision from %s', 'wpmvcb'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
				6 => sprintf( __('Book published. <a href="%s">View Book</a>', 'wpmvcb'), esc_url( get_permalink($post->ID) ) ),
				7 => __('Book saved.', 'wpmvcb'),
				8 => sprintf( __('Book submitted. <a target="_blank" href="%s">Preview book</a>', 'wpmvcb'), esc_url( add_query_arg( 'preview', 'true', get_permalink( $post->ID) ) ) ),
				9 => sprintf( __('Book scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview book</a>', 'wpmvcb'),
				  // translators: Publish box date format, see http://php.net/date
				  date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink( $post->ID ) ) ),
				10 => sprintf( __('Book draft updated. <a target="_blank" href="%s">Preview book</a>', 'wpmvcb'), esc_url( add_query_arg( 'preview', 'true', get_permalink( $post->ID) ) ) )
			);
			
			$this->assertArrayHasKey( 'foocptslug', $messages, __( 'Messages not present in array', 'wpmvcb' ) );
			$this->assertEquals( $expected, $messages['foocptslug'] );

		}
				
		/**
		 * @covers ::on_load
		 */
		public function testActionPostUpdatedMessagesExists()
		{
			$this->assertFalse( false === has_filter( 'post_updated_messages', array( 'Base_Controller_CPT', 'post_updated_messages' ) ) );
		}

	}

}
