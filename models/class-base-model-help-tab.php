<?php
 /*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

if ( ! class_exists( 'Base_Model_Help_Tab' ) ):
	/**
	 * The help tab model.
	 *
	 * @package WPMVCBase\Models
	 * @since   WPMVCBase 0.1
	 */
	class Base_Model_Help_Tab
	{
		/**
		 * The help tab id.
		 *
		 * @var    string
		 * @since  WPMVCBase 0.1
		 * @access private
		 * @link   http://codex.wordpress.org/Function_Reference/add_help_tab
		 */
		private $id;

		/**
		 * The help tab title.
		 *
		 * @var    string
		 * @access private
		 * @since  WPMVCBase 0.1
		 */
		private $title;
		
		/**
		 * The admin screens on which to display this help tab.
		 * 
		 * This array contains the WP screen id's for the screens on which to load this help tab 
		 * ( e.g. 'Add New Post', 'Reading Settings', etc ). There is a highly incomplete listing of screen ids
		 * @link http://codex.wordpress.org/Plugin_API/Admin_Screen_Reference
		 *
		 * Primarily, the most used are:
		 * load-post.php      The 'All Posts' page. This also applies to pages and custom post types.
		 * load-post-edit.php The page loaded to edit an existing post/page/cpt.
		 * load-post-new.php  The page loaded when creating a new post/page/cpt.
		 *
		 * @var    array
		 * @access private
		 * @since  WPMVCBase 0.2
		 */
		private $screens;
		
		/**
		 * The post types on which to display this help tab.
		 * 
		 * This property is used in conjunction with the $screens property to determine upon which admin pages
		 * to display this help tab.
		 *
		 * For example, if the post_types property is set to 'post' and the $screens property is set to 'load-post-new.php',
		 * this tab will appear on only the Create New Post page for posts ( not pages ).
		 *
		 * @var    array
		 * @access private
		 * @since  WPMVCBase 0.2
		 */
		private $post_types;
		
		/**
		 * The help tab content.
		 *
		 * @var    string
		 * @access private
		 * @since  WPMVCBase 0.1
		 */
		private $content;

		/**
		 * The class constructor.
		 *
		 * @param  string       $title      The help tab title.
		 * @param  string       $id         The help tab id.
		 * @param  array        $screens    The screens on which to add the help screen tab.
		 * @param  array        $post_types The post types on which to display this help tab
		 * @param  string       $content    The help tab content. If null, the callback will be used to populate the content.
		 * @access public
		 * @since  WPMVCBase 0.1
		 */
		public function __construct( $id, $title, array $screens, array $post_types, $content )
		{
			$this->id         = $id;
			$this->title      = $title;
			$this->screens    = $screens;
			$this->post_types = $post_types;
			$this->content    = $content;
		}

		/**
		 * Get the help tab title.
		 *
		 * @access public
		 * @since  WPMVCBase 0.1
		 */
		public function get_title()
		{
			return $this->title;
		}

		/**
		 * Get the help tab id.
		 *
		 * @access public
		 * @since  WPMVCBase 0.1
		 */
		public function get_id()
		{
			return $this->id;
		}
		
		/**
		 * Get the help tab screens.
		 *
		 * @return array $screens
		 * @access public
		 * @since  WPMVCBase 0.2
		 */
		public function get_screens()
		{
			return $this->screens;
		}

		/**
		 * Get the post types associated with this help tab.
		 *
		 * @return array $post_types
		 * @access public
		 * @since  WPMVCBase 0.2
		 */
		public function get_post_types()
		{
			return $this->post_types;
		}
		
		/**
		 * Set the help tab content.
		 *
		 * @return string $content
		 * @access public
		 * @since  WPMVCBase 0.1
		 */
		
		public function get_content()
		{
			return $this->content;
		}
	}
endif;
