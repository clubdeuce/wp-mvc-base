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
		 * The class constructor.
		 *
		 * @param string       $title     The help tab title.
		 * @param string       $id        The help tab id.
		 * @param array        $screens   The screens on which to add the help screen tab.
		 * @param string       $content   The help tab content. If null, the callback will be used to populate the content.
		 * @since 0.1
		 */
		public function __construct( $title, $id, array $screens, $content )
		{
			$this->id       = $id;
			$this->title    = $title;
			$this->screens  = $screens;
			$this->content  = $content;
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
			return $this->screens;
		}

		/**
		 * Set the help tab content.
		 *
		 * @return string $content
		 * @since 0.1
		 */
		
		public function get_content()
		{
			return $this->content;
		}
	}
endif;
