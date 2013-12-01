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
		 * The plugin path.
		 *
		 * This is the base directory for the plugin ( e.g. /home/user/public_html/wp-content/plugins/my-plugin ).
		 *
		 * @var string
		 * @access protected
		 * @since 0.1
		 */
		protected $_path;

		/**
		 * The plugin app path.
		 *
		 * @var string
		 * @access protected
		 * @since 0.1
		 */
		protected $_app_path;

		/**
		 * The base directory path.
		 *
		 * @var string
		 * @access protected
		 * @since 0.1
		 */
		protected $_base_path;

		/**
		 * The absoulte path to the main plugin file.
		 *
		 * @var string
		 * @access protected
		 * @since 0.1
		 */
		protected $_main_plugin_file;

		/**
		  * The plugin uri.
		  *
		  * @category Controllers
		  * @package WPMVCBase
		  * @var string
		  * @access protected
		  * @since 0.1
		  */
		protected $_uri;

		/**
		/**
		 * The plugin text domain
		 *
		 * @var string
		 * @access protected
		 * @since 0.1
		 */
		protected $_txtdomain;
		
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
		 * The class constructor.
		 *
		 * @param string $main_plugin_file
		 * @param string $app_path
		 * @param string $base_path
		 * @param string $uri
		 * @param string $txtdomain
		 * @since 0.1
		 */
		public function __construct(  $main_plugin_file, $plugin_path, $app_path, $base_path, $uri, $txtdomain = null )
		{
			$this->_main_plugin_file = $main_plugin_file;
			$this->_path             = trailingslashit( $plugin_path );
			$this->_app_path         = trailingslashit( $app_path );
			$this->_base_path        = trailingslashit( $base_path );
			$this->_uri              = trailingslashit( $uri );
			$this->_txtdomain        = $txtdomain;
		}
		
		/**
		 * Get the frontend CSS.
		 *
		 * @package WPMVCBase\Models
		 * @return array\bool $css if set, FALSE if not.
		 * @since 0.1
		 */
		public function get_css()
		{
			if ( isset( $this->css ) ) {
				return $this->css;
			}
			
			return false;
		}

		/**
		 * Get the admin CSS.
		 *
		 * @package WPMVCBase\Models
		 * @return array|bool $admin_css if set, FALSE if not.
		 * @since 0.1
		 */
		public function get_admin_css()
		{
			if ( isset( $this->admin_css ) ) {
				return $this->admin_css;
			}
			
			return false;
		}

		/**
		 * Get the front end javascripts.
		 *
		 * @return array $scripts if set, FALSE if not.
		 * @since 0.1
		 */
		public function get_scripts()
		{
			if ( isset( $this->scripts ) ) {
				return $this->scripts;
			}
			
			return false;
		}

		/**
		 * Get the admin javascripts.
		 *
		 * @return array|bool $admin_scripts if set, FALSE if not.
		 * @since 0.1
		 */
		public function get_admin_scripts()
		{
			if ( isset( $this->admin_scripts ) ) {
				return $this->admin_scripts;
			}
			
			return false;
		}

		/**
		 * Get the model's metaboxes.
		 *
		 * @return array|bool $metaboxes if set, FALSE if not.
		 * @see WP_Metabox
		 * @since 0.1
		 */
		public function get_metaboxes()
		{
			if ( isset( $this->metaboxes ) ) {
				return $this->metaboxes;
			}
			
			return false;
		}

		/**
		 * Get the cpt help screen tabs.
		 *
		 * @return array|bool $help_tabs if set, FALSE if not.
		 * @access public
		 * @since 0.1
		 */
		public function get_help_tabs()
		{
			if ( isset( $this->help_tabs ) ) {
				return $this->help_tabs;
			}
			
			return false;
		}

		/**
		 * Get the cpt help screen tabs.
		 *
		 * @return array|FALSE $_help_tabs if set, FALSE if not.
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
		
		/**
		 * Get the model's shortcodes.
		 *
		 * @return array|bool $shortcodes if set, FALSE if not.
		 * @since 0.1
		 */
		public function get_shortcodes()
		{
			if ( isset( $this->shortcodes ) ) {
				return $this->shortcodes;
			}
			
			return false;
		}

		/**
		 * Add a metabox.
		 *
		 * @param string $handle The metabox handle.
		 * @param object $metabox A metabox object.
		 * @return bool|object TRUE on success, WP_Error on failure.
		 * @see Base_Model_Metabox
		 * @since 0.1
		 */
		public function add_metabox( $handle, $metabox )
		{
			if ( ! isset( $this->metaboxes) ) {
				$this->metaboxes = array();
			}
						
			if ( $metabox instanceOf Base_Model_Metabox ) {
				$this->metaboxes = array_merge( $this->metaboxes, array( $handle => $metabox ) );
				return true;
			}
			
			return new WP_Error(
				'fail',
				sprintf( 
					__( '%s::%s expects a Base_Model_Metabox object as the second parameter', 'wpmvcb' ),
					__CLASS__,
					__FUNCTION__
				),
				$metabox
			);
		}

		/**
		 * Add a help tab object.
		 *
		 * @param string $handle The help tab handle.
		 * @param object $help_tab The Base_Model_Help_Tab object.
		 * @return bool|object TRUE on success, WP_Error on failure.
		 * @since 0.2
		 * @see Base_Model_Help_Tab
		 */
		public function add_help_tab( $handle, $help_tab )
		{
			if ( ! is_array( $this->_help_tabs ) ) {
				$this->help_tabs = array();
			}
			
			if ( $help_tab instanceOf Base_Model_Help_Tab ) {
				$this->help_tabs = array_merge( $this->help_tabs, array( $handle => $help_tab ) );
				return true;
			}
			
			//A valid help tab object is not included.
			return new WP_Error(
				'invalid object type',
				sprintf( __( '%s::%s expects a Base_Model_Help_Tab object as the second parameter', 'wpmvcb' ), __CLASS__, __FUNCTION__ ),
				$help_tab
			);
		}
		
		/**
		 * Add a shortcode object.
		 *
		 * @param string $shortcode The shortcode name.
		 * @param string $callback The shortcode callback handler.
		 * @return void
		 * @since 0.1
		 */
		public function add_shortcode( $shortcode, $callback )
		{
			if ( ! isset( $this->shortcodes ) ) {
				$this->shortcodes = array();
			}
			
			if ( is_callable( $callback ) ) {
				$this->shortcodes = array_merge( $this->shortcodes, array( $shortcode => $callback ) );
				return true;
			}
			
			return new WP_Error(
				'not callable',
				sprintf( __( '%s::%s expects a valid callback.', 'wpmvcb' ), __CLASS__, __FUNCTION__ ),
				$callback
			);
		}
	}
endif;
