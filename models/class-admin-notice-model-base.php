<?php
/**
 * @license GPLv2.0 or later
 */

if ( ! class_exists( 'WPMVCB_Admin_Notice_Model_Base' ) ) {
	/**
	 * The base admin notice object model.
	 *
	 * @package WPMVCBase\Models
	 * @version 0.2
	 * @since   WPMVCBase 0.2
	 */
	class WPMVCB_Admin_Notice_Model_Base
	{
		/**
		 * The notice type ( updated or error ).
		 * 
		 * @var    string
		 * @access private
		 * @since  WPMVCBase 0.2
		 */
		private $type;
		
		/**
		 * The admin notice message.
		 * 
		 * @var    string
		 * @access private
		 * @since  WPMVCBase 0.2
		 */
		private $message;
		
		/**
		 * The screens on which to display this admin notice.
		 * 
		 * @var    array
		 * @access private
		 * @since  WPMVCBase 0.2
		 */
		private $screens;
		
		/**
		 * The class constructor.
		 *
		 * @param  mixed[] $args Contains the following potential elements:
		 *              string $type The notice type. Either 'updated' or 'error'.
		 *              string $message The notice message.
		 *              array  $screens The WP screen id's on which to display this notice. If not set, notice appears on all screens.
		 * @access public
		 * @since  WPMVCBase 0.2
		 */
		public function __construct( array $args = array() )  {

			$args = wp_parse_args( $args, array(
				'type'    => null,
				'message' => null,
				'screens' => array()
			) );

			$this->type    = $args['type'];
			$this->message = $args['message'];
			$this->screens = $args['screens'];

		}
		
		/**
		 * Get the notice type.
		 *
		 * @return string $type Either 'updated' or 'error'.
		 * @access public
		 * @since  WPMVCBase 0.2
		 */
		public function get_type() {

			return $this->type;

		}
		
		/**
		 * Get the admin notice message.
		 *
		 * @return string $message
		 * @access public
		 * @since  WPMVCBase 0.2
		 */
		public function get_message() {

			return $this->message;

		}
		
		/**
		 * Get the screen(s) on which to apply this notice.
		 *
		 * @return array   $screens An array of the screens or the string 'all' for all screens.
		 * @access public
		 * @since  WPMVCBase 0.2
		 */
		public function get_screens() {

			return $this->screens;

		}

	}

}
