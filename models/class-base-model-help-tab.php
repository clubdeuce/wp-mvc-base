<?php
/**
 * The base help tab model
 *
 * @author Daryl Lozupone <daryl@actionhook.com>
 * @copyright 2013
 * @version 0.1
 * @since WPMVCBase 0.1
 */

if ( ! class_exists( 'Base_Model_Help_Tab' ) ):
	/**
	 * The help tab model.
	 *
	 * @package WPMVCBase\Models
	 * @since 0.1
	 */
	class Base_Model_Help_Tab
	{
		/**
		 * The help tab id.
		 *
		 * @var string
		 * @see http://codex.wordpress.org/Function_Reference/add_help_tab
		 * @since 0.1
		 */
		private $id;

		/**
		 * The help tab title.
		 *
		 * @var string
		 * @since 0.1
		 */
		private $title;
		
		/**
		 * The admin screens on which to display this help tab.
		 * 
		 * @var array
		 * @since 1.0
		 */
		private $screens;
		
		/**
		 * The help tab content.
		 *
		 * @var string
		 * @since 0.1
		 */
		private $content;

		/**
		 * The help tab callback function.
		 *
		 * @var string|array
		 * @since 0.1
		 */
		private $callback;

		/**
		 * The help tab view file.
		 *
		 * This must be an absolute path to the view file.
		 *
		 * @var string
		 * @since 0.1
		 */
		private $view;

		/**
		 * The class constructor.
		 *
		 * @param string       $title     The help tab title.
		 * @param string       $id        The help tab id.
		 * @param array        $screens   The screens on which to add the help screen tab.
		 * @param string       $content   The help tab content. If null, the callback will be used to populate the content.
		 * @param string|array $callback  The help tab callback. If null, the view will be used to populate the content.
		 * @param string       $view      The absolute path to the view file used to render this help tab. Must be set if $content and $callback are null.
		 * @since 0.1
		 */
		public function __construct( $title, $id, array $screens, $content = null, $callback = null, $view = null )
		{
			if ( ! isset( $content ) && ! isset( $callback ) && ! isset( $view ) ) {
				trigger_error(
					'You must specify either the help tab content, a callback function, or a view to use for the help tab',
					E_USER_WARNING
				);
			}
			
			$this->id       = $id;
			$this->title    = $title;
			$this->screens  = $screens;
			$this->content  = $content;
			$this->callback = $callback;
			$this->view     = $view;
		}

		/**
		 * Add this help tab to the current screen.
		 *
		 * @link http://codex.wordpress.org/Function_Reference/add_help_tab
		 * @since 0.1
		 */
		public function add()
		{
			if ( is_null( $this->callback ) && file_exists( $this->view ) ) {
				ob_start();
				require_once( $this->view );
				$this->content = ob_get_clean();
			}
			get_current_screen()->add_help_tab( array( 'id' => $this->id, 'title' => $this->title, 'content' => $this->content ) );
		}

		/**
		 * Get the help tab title.
		 *
		 * @since 0.1
		 */
		public function get_title()
		{
			return $this->title;
		}

		/**
		 * Get the help tab id.
		 *
		 * @since 0.1
		 */
		public function get_id()
		{
			return $this->id;
		}
		
		/**
		 * Get the help tab screens.
		 *
		 * @return array $screens
		 * @since 1.0
		 */
		public function get_screens()
		{
			if ( isset( $this->screens ) ) {
				return $this->screens;
			}
			
			return false;
		}
		
		/**
		 * Set the help tab callback.
		 *
		 * @param string|array $callback The help tab callback.
		 * @since 0.1
		 */
		public function set_callback( $callback )
		{
			if ( ! is_callable( $callback ) ):
				trigger_error(
					__( 'A valid callback function must be specified', 'wp-mvc-base' ),
					E_USER_WARNING
				);

				return false;
			endif;

			$this->callback = $callback;

			return true;
		}

		/**
		 * Set the help tab content.
		 *
		 * @param string $content The help tab content.
		 * @since 0.1
		 */
		public function set_content( $content )
		{
			$this->content = $content;
		}
	}
endif;
