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

if ( ! class_exists( 'WPMVCB_Menu_Page_Model_Base' ) ) {
	/**
	 * The base options page model.
	 *
	 * @package WPMVCBase\Models
	 * @since WPMVCBase 0.2
	 */
	class WPMVCB_Menu_Page_Model_Base
	{
		/**
		 * The The slug name for the parent menu item.
		 *
		 * @var    string
		 * @access private
		 * @since WPMVCBase 0.2
		 */
		private $parent_slug;

		/**
		 * The text to be displayed in the title tags of the page when the menu is selected.
		 *
		 * @var    string
		 * @access private
		 * @since  WPMVCBase 0.2
		 */
		private $page_title;

		/**
		 * The text to be used for the menu item.
		 *
		 * @var    string
		 * @access private
		 * @since  WPMVCBase 0.2
		 */
		private $menu_title;

		/**
		 * The capability required for this menu to be displayed to the user.
		 *
		 * @var string
		 * @since WPMVCBase 0.2
		 * @link http://codex.wordpress.org/Roles_and_Capabilities
		 */
		private $capability;

		/**
		 * The slug name to refer to this menu by (should be unique for this menu).
		 *
		 * If you want to NOT duplicate the parent menu item, you need to set the name of the
		 * $menu_slug exactly the same as the parent slug.
		 *
		 * @var    string
		 * @access private
		 * @since  WPMVCBase 0.2
		 */
		private $menu_slug;

		/**
		 * The function to be called to output the content for this page.
		 *
		 * You can specify a function here, or leave it unset. If unset, the plugin controller will use
		 * the default render_options_page() method.
		 *
		 * @var    string|array
		 * @access private
		 * @since  WPMVCBase 0.2
		 */
		private $callback;

		/**
		 * The url to the icon to be used for this menu.
		 *
		 * This parameter is optional. Icons should be fairly small, around 16 x 16 pixels for best results.
		 * You can use the plugin_dir_url( __FILE__ ) function to get the URL of your plugin directory and
		 * then add the image filename to it. You can set $icon_url to "div" to have wordpress generate
		 * <br> tag instead of <img>. This can be used for more advanced formating via CSS, such as
		 * changing icon on hover.
		 *
		 * @var    string
		 * @access private
		 * @since  WPMVCBase 0.2
		 */
		private $icon_url;

		/**
		 * The position in the menu order this menu should appear.
		 *
		 * By default, if this parameter is omitted, the menu will appear at the bottom of the menu structure.
		 * The higher the number, the lower its position in the menu. WARNING: if two menu items use the same
		 * position attribute, one of the items may be overwritten so that only one item displays! Risk of
		 * conflict can be reduced by using decimal instead of integer values, e.g. 63.3 instead of 63
		 * (Note: Use quotes in code, IE '63.3').
		 *
		 * @var    string
		 * @access private
		 * @since  WPMVCBase 0.2
		 */
		private $position;

		/**
		 * The javascripts used on this page.
		 *
		 * This is a collection of Base_Model_JS_Objects.
		 *
		 * @var    array
		 * @since  WPMVCBase 0.2
		 * @access private
		 * @see    Base_Model_JS_Object
		 */
		private $admin_scripts;

		/**
		 * The CSS used on this page.
		 *
		 * @var    array
		 * @access private
		 * @since  WPMVCBase 0.2
		 */
		private $admin_css;

		/**
		 * The help tabs for this page.
		 *
		 * This is a collection of Base_Model_Help_Tab objects.
		 *
		 * @var    array
		 * @access private
		 * @since  WPMVCBase 0.2
		 * @see    Base_Model_Help_Tabs
		 */
		private $help_tabs;

		/**
		 * The name of the view file used to render the page.
		 *
		 * This file must be present in the app/views folder. If not set ( or set and not present),
		 * a PHP warning will occur and the plugin controller will use a default view.
		 *
		 * @var    string
		 * @access private
		 * @since  WPMVCBase 0.2
		 */
		private $view;

		/**
		 * The hook suffix assigned by WordPress when the page is added.
		 *
		 * @var    string
		 * @access private
		 * @since  WPMVCBase 0.2
		 */
		private $hook_suffix;

		/**
		 * Set the parent_slug property.
		 *
		 * @param  $slug
		 * @access public
		 * @since  WPMVCBase 0.2
		 */
		public function set_parent_slug( $slug )
		{
			$this->parent_slug = $slug;
		}

		/**
		 * Get the parent_slug property.
		 *
		 * @return string|void
		 * @access public
		 * @since  WPMVCBase 0.2
		 */
		public function get_parent_slug()
		{
			if ( isset( $this->parent_slug ) ) {
				return $this->parent_slug;
			}
		}

		/**
		 * Set the _page_title property.
		 *
		 * @param  string $page_title
		 * @access public
		 * @since  WPMVCBase 0.2
		 */
		public function set_page_title( $page_title )
		{
			$this->page_title = $page_title;
		}

		/**
		 * Get the page_title property.
		 *
		 * @return string|void
		 * @access public
		 * @since  WPMVCBase 0.2
		 */
		public function get_page_title()
		{
			if ( isset( $this->page_title ) ) {
				return $this->page_title;
			}
		}

		/**
		 * Set the menu_title property.
		 *
		 * @param  string $title
		 * @access public
		 * @since  WPMVCBase 0.2
		 */
		public function set_menu_title( $title )
		{
			$this->menu_title = $title;
		}

		/**
		 * Get the menu_title property.
		 *
		 * @return string|void
		 * @access public
		 * @since  WPMVCBase 0.2
		 */
		public function get_menu_title()
		{
			if ( isset( $this->menu_title ) ) {
				return $this->menu_title;
			}
		}

		/**
		 * Set the capability property.
		 *
		 * @param  string $capability
		 * @access public
		 * @since  WPMVCBase 0.2
		 */
		public function set_capability( $capability )
		{
			$this->capability = $capability;
		}

		/**
		 * Get the capability property.
		 *
		 * @return string|void
		 * @access public
		 * @since  WPMVCBase 0.2
		 */
		public function get_capability()
		{
			if ( isset( $this->capability ) ) {
				return $this->capability;
			}
		}

		/**
		 * Set the menu_slug property.
		 *
		 * @param  string $slug
		 * @access public
		 * @since  WPMVCBase 0.2
		 */
		public function set_menu_slug( $slug )
		{
			$this->menu_slug = $slug;
		}

		/**
		 * Get the menu_slug property.
		 *
		 * @return string $menu_slug
		 * @access public
		 * @since  WPMVCBase 0.2
		 */
		public function get_menu_slug()
		{
			if ( isset( $this->menu_slug ) ) {
				return $this->menu_slug;
			}
		}

		/**
		 * Set the callback property.
		 *
		 * @param  string $callback
		 * @access public
		 * @since  WPMVCBase 0.2
		 */
		public function set_callback( $callback )
		{
			$this->callback = $callback;
		}

		/**
		 * Get the callback property.
		 *
		 * @return string $callback
		 * @access public
		 * @since  WPMVCBase 0.2
		 */
		public function get_callback()
		{
			if ( isset( $this->callback ) ) {
				return $this->callback;
			}
		}

		/**
		 * Set the icon_url property.
		 *
		 * @param  string $icon_url
		 * @access public
		 * @since  WPMVCBase 0.2
		 */
		public function set_icon_url( $icon_url )
		{
			$this->icon_url = $icon_url;
		}

		/**
		 * Get the icon_url property.
		 *
		 * @return string
		 * @access public
		 * @since  WPMVCBase 0.2
		 */
		public function get_icon_url()
		{
			if ( isset( $this->icon_url ) ) {
				return $this->icon_url;
			}
		}

		/**
		 * Set the position property.
		 *
		 * @param  string $position
		 * @access public
		 * @since  WPMVCBase 0.2
		 */
		public function set_position( $position )
		{
			$this->position = $position;
		}

		/**
		 * Get the position property.
		 *
		 * @return string
		 * @access public
		 * @since  WPMVCBase 0.2
		 */
		public function get_position()
		{
			if ( isset( $this->position ) ) {
				return $this->position;
			}
		}

		/**
		 * Set the admin_scripts property.
		 *
		 * @param  array $admin_scripts
		 * @access public
		 * @since  WPMVCBase 0.2
		 */
		public function set_admin_scripts( $admin_scripts )
		{
			$this->admin_scripts = $admin_scripts;
		}

		/**
		 * Get the admin_scripts property.
		 *
		 * @return array
		 * @access public
		 * @since  WPMVCBase 0.2
		 */
		public function get_admin_scripts()
		{
			if ( isset( $this->admin_scripts ) ) {
				return $this->admin_scripts;
			}
		}

		/**
		 * Set the admin_css property.
		 *
		 * @param  array $admin_css
		 * @access public
		 * @since  WPMVCBase 0.2
		 */
		public function set_admin_css( $admin_css )
		{
			$this->admin_css = $admin_css;
		}

		/**
		 * Get the admin_css property.
		 *
		 * @return array
		 * @access public
		 * @since  WPMVCBase 0.2
		 */
		public function get_admin_css()
		{
			if ( isset( $this->admin_css ) ) {
				return $this->admin_css;
			}
		}

		/**
		 * Set the help_tabs property.
		 *
		 * @param array $help_tabs
		 * @access public
		 * @since  WPMVCBase 0.2
		 */
		public function set_help_tabs( $help_tabs )
		{
			$this->help_tabs = $help_tabs;
		}

		/**
		 * Get the help_tabs property.
		 *
		 * @return array|null
		 * @access public
		 * @since  WPMVCBase 0.2
		 */
		public function get_help_tabs()
		{
			if ( isset( $this->help_tabs ) ) {
				return $this->help_tabs;
			}
		}

		/**
		 * Set the view property.
		 *
		 * @param  string $view
		 * @access public
		 * @since  WPMVCBase 0.2
		 */
		public function set_view( $view )
		{
			$this->view = $view;
		}

		/**
		 * Get the view property.
		 *
		 * @return string
		 * @access public
		 * @since  WPMVCBase 0.2
		 */
		public function get_view()
		{
			if ( isset( $this->view ) ) {
				return $this->view;
			}
		}

		/**
		 * Get the hook_suffix property.
		 *
		 * @return string|void
		 * @access public
		 * @since  WPMVCBase 0.2
		 */
		public function get_hook_suffix()
		{
			if ( isset( $this->hook_suffix ) ) {
				return $this->hook_suffix;
			}
		}

		/**
		 * Add the options page
		 *
		 * @return string|false The hook suffix on success, FALSE if user does not have required capability.
		 * @access public
		 * @since  WPMVCBase 0.2
		 * @link   http://codex.wordpress.org/Function_Reference/add_menu_page
		 * @link   http://codex.wordpress.org/Function_Reference/add_submenu_page
		 */
		public function add()
		{
			if ( isset( $this->parent_slug ) ) {
				$this->hook_suffix = add_submenu_page( $this->parent_slug, $this->page_title, $this->menu_title, $this->capability, $this->menu_slug, $this->callback );
				return $this->hook_suffix;
			}
			
			$this->hook_suffix = add_menu_page( $this->page_title, $this->menu_title, $this->capability, $this->menu_slug, $this->callback, $this->icon_url, $this->position );
			
			return $this->hook_suffix;
		}
	}
}
