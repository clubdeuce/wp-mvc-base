<?php
/**
 * The base model.
 *
 * @package WPMVCBase\Models
 * @author Daryl Lozupone <daryl@actionhook.com>
 * @since WPMVCBase 0.1
 */

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

if ( ! class_exists( 'Base_Model' ) ) :
	/**
	 * The base model.
	 *
	 * This class serves as the base for other models provided by the framework. It contains the properties and
	 * and methods required by other models.
	 *
	 * @package WPMVCBase\Models
	 * @internal
	 * @since WPMVCBase 0.1
	 */
	abstract class Base_Model
	{
		/**
		 * The class version
		 *
		 * @package WPMVCBase\Models
		 * @var string
		 * @since 0.2
		 */
		private $version = '0.2';

		/**
		 * The plugin css files
		 *
		 * An array containing css used by the model.
		 *
		 * @package WPMVCBase\Models
		 * @var array
		 * @since 0.1
		 */
		protected $css;

		/**
		 * The plugin admin css files.
		 *
		 * An array containing css used by the model on admin pages
		 *
		 * @package WPMVCBase\Models
		 * @var array
		 * @since 0.1
		 */
		protected $admin_css;

		/**
		 * The model javascript files
		 *
		 * An array containing a collection of javascript objects used by the model on the frontend.
		 *
		 * @package WPMVCBase\Models
		 * @see WPMVCBase\Models\Base Model JS Object
		 * @var array
		 * @since 0.1
		 */
		protected $scripts;

		/**
		 * The model admin javascript files
		 *
		 * An array containing a collection of javascript objects used by the model on admin pages.
		 *
		 * @package WPMVCBase\Models
		 * @var array
		 * @since 0.1
		 */
		protected $admin_scripts;

		/**
		 * Metaboxes required by this model.
		 *
		 * @package WPMVCBase\Models
		 * @var array Contains an array of WP_Base_Metabox objects
		 * @see WPMVCBase\Models\Base_Model_Metabox
		 * @since 0.1
		 */
		protected $metaboxes;

		/**
		 * The model's help tabs.
		 *
		 * This is a collection of Base_Model_Help_Tab objects.
		 *
		 * @var array
		 * @since 0.2
		 * @see Base_Model_Help_Tabs
		 */
		protected $help_tabs;

		/**
		 * The model's shortcodes.
		 *
		 * @var array
		 * @since 0.2
		 */
		protected $shortcodes;

		/**
		 * Get the frontend CSS.
		 *
		 * @package WPMVCBase\Models
		 * @param string $uri The plugin css uri ( e.g. http://example.com/wp-content/plugins/myplugin/css )
		 * @return array $admin_css
		 * @since 0.1
		 */
		public function get_css( $uri )
		{
			if ( ! isset( $this->css ) && method_exists( $this, 'init_css' ) ) {
				$this->init_css( $uri );
			}

			return $this->css;
		}

		/**
		 * Get the admin CSS.
		 *
		 * @package WPMVCBase\Models
		 * @param string $uri The plugin css uri ( e.g. http://example.com/wp-content/plugins/myplugin/css )
		 * @return array $admin_css Collection of admin css objects.
		 * @since 0.1
		 */
		public function get_admin_css( $uri )
		{
			if ( ! isset( $this->admin_css ) && method_exists( $this, 'init_admin_css' ) ) {
				$this->init_admin_css( $uri );
			}
			
			if ( is_array( $this->admin_css ) ) :
				foreach ( $this->admin_css as $key => $css ) :
					//filter the css elements
					$this->admin_css[$key] = apply_filters( 'ah_base_filter_admin_css-' . $css['handle'], $css );
				endforeach;
			endif;

			return $this->admin_css;
		}

		/**
		 * Get the front end javascripts.
		 *
		 * @package WPMVCBase\Models
		 * @param object $post The WP Post object
		 * @param string $txtdomain The plugin text domain.
		 * @param string $uri The plugin js uri ( e.g. http://example.com/wp-content/plugins/myplugin/js )
		 * @return array $admin_scripts Collection of admin scripts.
		 * @since 0.1
		 */
		public function get_scripts( $post, $txtdomain, $uri )
		{
			if ( ! isset( $this->scripts ) && method_exists( $this, 'init_scripts' ) ) {
				$this->init_scripts( $uri );
			}
			
			return $this->scripts;
		}

		/**
		 * Get the admin javascripts.
		 *
		 * @package WPMVCBase\Models
		 * @param object $post The WP Post object
		 * @param string $txtdomain The plugin text domain.
		 * @param string $uri The plugin js uri ( e.g. http://example.com/wp-content/plugins/myplugin/js )
		 * @return array $admin_scripts
		 * @since 0.1
		 */
		public function get_admin_scripts( $post, $txtdomain, $uri = '' )
		{
			if ( ! isset( $this->admin_scripts ) && method_exists( $this, 'init_admin_scripts' ) ) {
				$this->init_admin_scripts( $post, $txtdomain, $uri );
			}

			return $this->admin_scripts;
		}

		/**
		 * Get the model's metaboxes
		 *
		 * This function will return the metaboxes. The post_id parameter
		 * is used so that this function may return the values stored for
		 * the corresponding custom fields in the callback arguments.
		 *
		 * @package WPMVCBase\Models
		 * @param string $post_id
		 * @param string $txtdomain the text domain to use for translations
		 * @return array $metaboxes an array of WP_Metabox objects
		 * @see WP_Metabox
		 * @since 0.1
		 */
		public function get_metaboxes( $post_id, $txtdomain )
		{
			if ( ! isset( $this->metaboxes ) && method_exists( $this, 'init_metaboxes' ) ) {
				$this->init_metaboxes( $post_id, $txtdomain );
			}

			return $this->metaboxes;
		}

		/**
		 * Get the cpt help screen tabs.
		 *
		 * @return array $_help_tabs Contains the help screen tab objects.
		 * @access public
		 * @since 0.1
		 */
		public function get_help_tabs()
		{
			if ( isset( $this->help_tabs ) ) {
				return $this->help_tabs;
			}
		}

		/**
		 * Get the cpt help screen tabs.
		 *
		 * @return array|void $_help_tabs Contains the help screen tab objects. VOID on empty.
		 * @access public
		 * @deprecated
		 * @since 0.1
		 */
		public function get_help_screen()
		{
			//warn the user about deprecated function use
			Helper_Functions::deprecated( __FUNCTION__, 'get_help_tabs', $this->_txtdomain );

			//and point to the replacement function
			return $this->get_help_tabs();
		}

		public function get_shortcodes()
		{
			if ( isset( $this->shortcodes ) ) :
				return $this->shortcodes;
			endif;
		}

		public function add_metabox( $handle, $metabox )
		{
			if ( ! isset( $this->metaboxes) ):
				$this->metaboxes = array();
			endif;

			if ( $metabox instanceOf Base_Model_Metabox ) :
				$this->metaboxes = array_merge( $this->metaboxes, array( $handle => $metabox ) );
			else :
				trigger_error(
					sprintf( __( '%s expects a Base_Model_Metabox object as the second parameter', 'wpmvcb' ), __FUNCTION__ ),
					E_USER_WARNING
				);
			endif;
		}

		/**
		 * Add a help tab object.
		 *
		 * @param string $handle The help tab handle.
		 * @param object $help_tab The Base_Model_Help_Tab object.
		 * @since 0.2
		 * @see Base_Model_Help_Tab
		 */
		public function add_help_tab( $handle, $help_tab )
		{
			if ( ! is_array( $this->_help_tabs ) ):
				$this->help_tabs = array();
			endif;

			if ( $help_tab instanceOf Base_Model_Help_Tab ) {
				$this->help_tabs = array_merge( $this->help_tabs, array( $handle => $help_tab ) );

				return true;
			} else {
				trigger_error(
					sprintf( __( '%s expects a Base_Model_Help_Tab object as the second parameter', 'wpmvcb' ), __FUNCTION__ ),
					E_USER_WARNING
				);
			}
		}

		public function add_shortcode( $shortcode, $callback )
		{
			if ( ! isset( $this->shortcodes ) ) {
				$this->shortcodes = array();
			}

			$this->shortcodes = array_merge( $this->shortcodes, array( $shortcode => $callback ) );
		}
	}
endif;
