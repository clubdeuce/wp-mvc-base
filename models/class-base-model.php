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

if ( ! class_exists( 'Base_Model' ) ) :
	/**
	 * The base model.
	 *
	 * This class serves as the base for other models provided by the framework. It contains the properties and
	 * and methods required by other models.
	 *
	 * @package  WPMVCBase\Models
	 * @internal
	 * @since    WPMVCBase 0.1
	 */
	abstract class Base_Model
	{
		/**
		 * The class version
		 *
		 * @var    string
		 * @access private
		 * @since WPMVCBase 0.2
		 */
		private $version = '0.2';
		
		/**
		 * The plugin path.
		 *
		 * This is the base directory for the plugin ( e.g. /home/user/public_html/wp-content/plugins/my-plugin ).
		 *
		 * @var    string
		 * @access protected
		 * @since  WPMVCBase 0.1
		 */
		protected $path;

		/**
		 * The plugin app path.
		 *
		 * @var    string
		 * @access protected
		 * @since  WPMVCBase 0.1
		 */
		protected $app_path;

		/**
		 * The base directory path.
		 *
		 * @var    string
		 * @access protected
		 * @since  WPMVCBase 0.1
		 */
		protected $base_path;

		/**
		 * The absoulte path to the main plugin file.
		 *
		 * @var    string
		 * @access protected
		 * @since  WPMVCBase 0.1
		 */
		protected $main_plugin_file;

		/**
		  * The plugin uri.
		  *
		  * @var    string
		  * @access protected
		  * @since  WPMVCBase 0.1
		  */
		protected $uri;

		/**
		 * The uri to the js assets.
		 *
		 * @var    string
		 * @access protected
		 * @since  WPMVCBase 0.1
		 */
		protected $js_uri;

		/**
		 * The uri to the css assets.
		 *
		 * @var    string
		 * @access protected
		 * @since  WPMVCBase 0.1
		 */
		protected $css_uri;
		
		/**
		 * The plugin css files
		 *
		 * An array containing css used by the model.
		 *
		 * @var    array
		 * @access protected
		 * @since  WPMVCBase 0.1
		 */
		protected $css;

		/**
		 * The plugin admin css files.
		 *
		 * An array containing css used by the model on admin pages
		 *
		 * @var    array
		 * @access protected
		 * @since  WPMVCBase 0.1
		 */
		protected $admin_css;

		/**
		 * The model javascript files
		 *
		 * An array containing a collection of javascript objects used by the model on the frontend.
		 *
		 * @var    array
		 * @access protected
		 * @since  WPMVCBase 0.1
		 * @see    WPMVCBase\Models\Base Model JS Object
		 */
		protected $scripts;

		/**
		 * The model admin javascript files
		 *
		 * An array containing a collection of javascript objects used by the model on admin pages.
		 *
		 * @var    array
		 * @access protected
		 * @since  WPMVCBase 0.1
		 */
		protected $admin_scripts;

		/**
		 * Metaboxes required by this model.
		 *
		 * @var    array Contains an array of WP_Base_Metabox objects
		 * @access protected
		 * @since  WPMVCBase 0.1
		 * @see    WPMVCBase\Models\Base_Model_Metabox
		 */
		protected $metaboxes;

		/**
		 * The model's help tabs.
		 *
		 * This is a collection of Base_Model_Help_Tab objects.
		 *
		 * @var    array
		 * @access protected
		 * @since  WPMVCBase 0.2
		 * @see    Base_Model_Help_Tabs
		 */
		protected $help_tabs;

		/**
		 * The model's shortcodes.
		 *
		 * @var    array
		 * @access protected
		 * @since  WPMVCBase 0.2
		 */
		protected $shortcodes;
		
		/**
		 * The model's admin notices.
		 *
		 * This is a collection of Base_Model_Admin_Notice objects.
		 *
		 * @var    array
		 * @access protected
		 * @since  WPMVCBase 0.2
		 * @see    Base_Model_Admin_Notice
		 */
		protected $admin_notices;
		
		/**
		 * The class constructor.
		 *
		 * @param  string $main_plugin_file
		 * @param  string $app_path
		 * @param  string $base_path
		 * @param  string $uri
		 * @param  string $txtdomain
		 * @param string $plugin_path
		 * @access public
		 * @since  WPMVCBase 0.1
		 */
		public function __construct(  $main_plugin_file, $plugin_path, $app_path, $base_path, $uri )
		{
			$this->main_plugin_file = $main_plugin_file;
			$this->path             = trailingslashit( $plugin_path );
			$this->app_path         = trailingslashit( $app_path );
			$this->base_path        = trailingslashit( $base_path );
			$this->uri              = trailingslashit( $uri );
			
			$this->init();
		}
		
		/**
		 * Initialize the child class.
		 *
		 * Use this function to set properties for your child class.
		 *
		 * @abstract
		 * @return    void
		 * @access    protected
		 * @since     WPMVCBase 0.2
		 */
		abstract protected function init();
		
		/**
		 * Get the main plugin file.
		 *
		 * @return      string The absolute path to the main plugin file.
		 * @access      public
		 * @deprecated
		 * @since       WPMVCBase 0.1
		 */
		public function main_plugin_file()
		{
			$helper = new Helper_Functions();
			$helper->deprecated( __FUNCTION__, 'get_main_plugin_file', 'wpmvcb' );

			return $this->main_plugin_file;
		}

		/**
		 * Get the main plugin file.
		 *
		 * @return string The absolute path to the main plugin file.
		 * @access public
		 * @since  WPMVCBase 0.1
		 */
		public function get_main_plugin_file()
		{
			return $this->main_plugin_file;
		}
		
		/**
		 * Get the plugin path.
		 *
		 * @return string The plugin path.
		 * @access public
		 * @since  WPMVCBase 0.1
		 */
		public function get_path()
		{
			return $this->path;
		}
		
		/**
		 * Get the plugin app path.
		 *
		 * @return string $app_path
		 * @access public
		 * @since  WPMVCBase 0.1
		 */
		public function get_app_path()
		{
			return $this->app_path;
		}
		
		/**
		 * Get the plugin app controllers path.
		 *
		 * @return string $app_controllers_path
		 * @access public
		 * @since  WPMVCBase 0.1
		 */
		public function get_app_controllers_path()
		{
			return $this->app_path . 'controllers/';
		}
		
		/**
		 * Get the plugin app models path.
		 *
		 * @return string $app_models_path
		 * @access public
		 * @since  WPMVCBase 0.1
		 */
		public function get_app_models_path()
		{
			return $this->app_path . 'models/';
		}
		
		/**
		 * Get the plugin app views path.
		 *
		 * @return string $app_views_path
		 * @access public
		 * @since  WPMVCBase 0.1
		 */
		public function get_app_views_path()
		{
			return $this->app_path . 'views/';
		}
		
		/**
		 * Get the plugin base path.
		 *
		 * @return string $base_path
		 * @access public
		 * @since  WPMVCBase 0.1
		 */
		public function get_base_path()
		{
			return $this->base_path;
		}
		
		/**
		 * Get the plugin base controllers path.
		 *
		 * @return string $base_controllers_path
		 * @access public
		 * @since  WPMVCBase 0.1
		 */
		public function get_base_controllers_path()
		{
			return $this->base_path . 'controllers/';
		}
		
		/**
		 * Get the plugin base models path.
		 *
		 * @return string $base_models_path
		 * @access public
		 * @since  WPMVCBase 0.1
		 */
		public function get_base_models_path()
		{
			return $this->base_path . 'models/';
		}
		
		/**
		 * Get the plugin base views path.
		 *
		 * @return string $base_views_path
		 * @access public
		 * @since  WPMVCBase 0.1
		 */
		public function get_base_views_path()
		{
			return $this->base_path . 'views/';
		}
		
		/**
		 * Get the plugin uri.
		 *
		 * @return string The plugin uri.
		 * @access public
		 * @since  WPMVCBase 0.1
		 */
		public function get_uri()
		{
			return $this->uri;
		}
		
		/**
		 * Get the frontend CSS.
		 *
		 * @return array\bool $css if set, FALSE if not.
		 * @access public
		 * @since  WPMVCBase 0.1
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
		 * @return array|bool $admin_css if set, FALSE if not.
		 * @access public
		 * @since  WPMVCBase 0.1
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
		 * @access public
		 * @since  WPMVCBase 0.1
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
		 * @access public
		 * @since  WPMVCBase 0.1
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
		 * @access public
		 * @since  WPMVCBase 0.1
		 * @see    WP_Metabox
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
		 * @since  WPMVCBase 0.1
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
		 * @return      array|FALSE $help_tabs if set, FALSE if not.
		 * @access      public
		 * @deprecated
		 * @since       WPMVCBase 0.1
		 */
		public function get_help_screen()
		{
			//warn the user about deprecated function use
			Helper_Functions::deprecated( __FUNCTION__, 'get_help_tabs', 'wpmvcb' );
			
			//and point to the replacement function
			return $this->get_help_tabs();
		}
		
		/**
		 * Get the model's shortcodes.
		 *
		 * @return array|bool $shortcodes if set, FALSE if not.
		 * @access public
		 * @since  WPMVCBase 0.1
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
		 * @param  string $handle The metabox handle.
		 * @param  object $metabox A metabox object.
		 * @return bool|object TRUE on success, WP_Error on failure.
		 * @access public
		 * @see    Base_Model_Metabox
		 * @since  WPMVCBase 0.1
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
		 * @param  string $handle The help tab handle.
		 * @param  object $help_tab The Base_Model_Help_Tab object.
		 * @return bool|object TRUE on success, WP_Error on failure.
		 * @access public
		 * @since  WPMVCBase 0.2
		 * @see    Base_Model_Help_Tab
		 */
		public function add_help_tab( $handle, $help_tab )
		{
			if ( ! is_array( $this->help_tabs ) ) {
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
		 * @param  string $shortcode The shortcode name.
		 * @param  string $callback The shortcode callback handler.
		 * @return void
		 * @access public
		 * @since  WPMVCBase 0.1
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
		
		/**
		 * WP save_post action authenticator.
		 *
		 * This method verifies an autosave is not in progress, the current user can edit the post being submitted,
		 * and that a valid nonce is present.
		 *
		 * @param    string $post_id      The WP post id.
		 * @param    string $post_type    The post type.
		 * @param    object $post_data    The POSTed data.
		 * @param    string $nonce_name   The name of the nonce.
		 * @param    string $nonce_action The nonce action.
		 * @internal
		 * @access   public
		 * @since    WPMVCBase 0.1
		 */
		public function authenticate_post( $post_id, $post_type, $post_data, $nonce_name, $nonce_action )
		{

			// verify if this is an auto save routine.
			// If it is our form has not been submitted, so we dont want to do anything
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
				return;
			}

			// We need to check if the current user is authorised to do this action.
			if ( 'page' == $post_type ) {
				if ( ! current_user_can( 'edit_page', $post_id ) ) {
					return;
				}
			}
			
			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return;
			}

			// Third we need to check if the user intended to change this value.
			if ( ! isset( $post_data[ $nonce_name ] ) || ! wp_verify_nonce( $post_data[ $nonce_name ], $nonce_action ) ) {
				return;
			}

			return true;
		}
		
		/**
		 * Get the admin notices attached to this model.
		 *
		 * @return array|bool
		 * @access public
		 * @since  WPMVCBase 0.2
		 */
		public function get_admin_notices()
		{
			if ( isset( $this->admin_notices ) ) {
				return $this->admin_notices;
			}
			
			return false;
		}

	}
endif;
