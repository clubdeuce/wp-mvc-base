<?php
/**
 * The base help tab model
 *
 * @package WP Base\Models
 * @author authtoken
 * @copyright 2013
 * @version 0.1
 * @since WP Base 0.1
 */

if ( ! class_exists( 'Base_Model_Help_Tab' ) ):
	/**
	 * The base help tab model.
	 *
	 * @package WP Base\Models
	 * @since 0.1
	 */
	class Base_Model_Help_Tab
	{
		/**
		 * The help tab id.
		 *
		 * @package WP Base\Models
		 * @var string
		 * @see http://codex.wordpress.org/Function_Reference/add_help_tab
		 * @since 0.1
		 */
		private $_id;
		
		/**
		 * The help tab title.
		 *
		 * @package WP Base\Models
		 * @var string
		 * @since 0.1
		 */
		private $_title;
		
		/**
		 * The help tab content.
		 *
		 * @package WP Base\Models
		 * @var string
		 * @since 0.1
		 */
		private $_content;
		
		/**
		 * The help tab callback function.
		 *
		 * @package WP Base\Models
		 * @var string|array
		 * @since 0.1
		 */
		private $_callback;
		
		/**
		 * The help tab view. This must be an absolute path to the view file.
		 *
		 * @package WP Base\Models
		 * @var string
		 * @since 0.1
		 */
		private $_view;
		
		/**
		 * The class constructor.
		 *
		 * @package WP Base\Models
		 * @param string $title The help tab title.
		 * @param string $id The help tab id.
		 * @param string $content The help tab content. If null, the callback will be used to populate the content.
		 * @param string|array $callback The help tab callback. If null, the view will be used to populate the content.
		 * @param string $view The absolute path to the view file used to render this help tab. Must be set if $content and $callback are null.
		 * @since 0.1
		 */
		public function __construct( $title, $id, $content = null, $callback = null, $view = null )
		{
			$this->_id = $id;
			$this->_title = $title;
			$this->_content = $content;
			$this->_callback = $callback;
			$this->_view = $view;
		}
		
		/**
		 * Add the help tab to the current screen.
		 *
		 * @package WP Base\Models
		 * @since 0.1
		 */
		public function add()
		{
			if( is_null( $this->_callback ) && file_exists( $this->_view ) ):
				ob_start();
				require_once( $this->_view );
				$this->_content = ob_get_clean();
			endif;
			get_current_screen()->add_help_tab( array('id' => $this->_id, 'title' => $this->_title, 'content' => $this->_content ) );
		}
		
		/**
		 * Set the help tab callback.
		 *
		 * @package WP Base\Models
		 * @param string|array $callback The help tab callback.
		 * @since 0.1
		 */
		public function set_callback( $callback )
		{
			$this->_callback = $callback;
		}
		
		/**
		 * Set the help tab content.
		 *
		 * @package WP Base\Models
		 * @param string $content The help tab content.
		 * @since 0.1
		 */
		public function set_content( $content )
		{
			$this->_content = $content;
		}
	}
endif;
?>