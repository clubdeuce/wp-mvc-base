<?php

/**
 * The base plugin model.
 *
 * @package MPMVCBase\Models
 * @version 0.2
 * @since 0.2
 * @author Daryl Lozupone <dlozupone@renegadetechconsulting.com>
 *
 */

include_once 'base_model.php';

if ( ! class_exists( 'Base_Model_Plugin' ) ):
	/**
	 * The base plugin model
	 *
	 * @package WPMVCBase\Models
	 * @version 0.2
	 * @since 0.2
	 */
	class Base_Model_Plugin extends Base_Model
	{
		/**
		 * The plugin slug.
		 *
		 * @var string
		 * @access protected
		 * @since 0.1
		 */
		protected $slug;

		/**
		 * The plugin version.
		 *
		 * @var string
		 * @access protected
		 * @since 0.1
		 */
		protected $version;

		/**
		 * The plugin path.
		 *
		 * This is the base directory for the plugin ( e.g. /home/user/public_html/wp-content/plugins/my-plugin ).
		 *
		 * @var string
		 * @access protected
		 * @since 0.1
		 */
		protected $path;

		/**
		 * The plugin app path.
		 *
		 * @var string
		 * @access protected
		 * @since 0.1
		 */
		protected $app_path;

		/**
		 * The plugin controllers path.
		 *
		 * @var string
		 * @access protected
		 * @since 0.1
		 */
		protected $app_controllers_path;

		/**
		 * The plugin models path.
		 *
		 * @var string
		 * @access protected
		 * @since 0.1
		 */
		protected $app_models_path;

		/**
		 * The plugin views path
		 *
		 * @var string
		 * @access protected
		 * @since 0.1
		 */
		protected $app_views_path;

		/**
		 * The base directory path.
		 *
		 * @var string
		 * @access protected
		 * @since 0.1
		 */
		protected $base_path;

		/**
		 * The base controllers path.
		 *
		 * This is the absolute path to the base classes 
		 * (e.g. /home/user/public_html/wp-content/plugins/my-plugin/base )
		 *
		 * @var string
		 * @access protected
		 * @since 0.1
		 */
		protected $base_controllers_path;

		/**
		 * The base models path.
		 *
		 * @var string
		 * @access protected
		 * @since 0.1
		 */
		protected $base_models_path;

		/**
		 * The base views path.
		 *
		 * @var string
		 * @access protected
		 * @since 0.1
		 */
		protected $base_views_path;

		/**
		 * The absoulte path to the main plugin file.
		 *
		 * @var string
		 * @access protected
		 * @since 0.1
		 */
		protected $main_plugin_file;

		/**
		  * The plugin uri.
		  *
		  * @category Controllers
		  * @package WPMVCBase
		  * @var string
		  * @access protected
		  * @since 0.1
		  */
		protected $uri;

		/**
		 * The uri to the js assets.
		 *
		 * @var string
		 * @access protected
		 * @since 0.1
		 */
		protected $js_uri;

		/**
		 * The uri to the css assets.
		 *
		 * @var string
		 * @access protected
		 * @since 0.1
		 */
		protected $css_uri;

		/**
		 * The plugin text domain
		 *
		 * @var string
		 * @access protected
		 * @since 0.1
		 */
		protected $txtdomain;

		/**
		 * The plugin custom post types.
		 *
		 * @var array Contains an array of cpt model objects
		 * @access protected
		 * @since 0.1
		 */
		protected $cpts;

		/**
		 * The plugin settings model.
		 *
		 * @var object
		 * @access protected
		 * @since 0.1
		 */
		protected $settings_model;

		/**
		 * The nonce name to be used for plugin form submissions.
		 *
		 * @var string
		 * @access protected
		 * @since 0.1
		 */
		protected $nonce_name;

		/**
		 * The nonce action to be used for plugin form submissions.
		 *
		 * @var string
		 * @access protected
		 * @since 0.1
		 */
		protected $nonce_action;

		/**
		 * The class constructor
		 *
		 * Example when called from the main plugin file:
		 * <code>
		 * $my_plugin_model = new Base_Model_Plugin(
		 *		'my_plugin_slug',
		 *		'1.1.5',
		 *		plugin_dir_path( __FILE__ ),
		 *		__FILE__,
		 *		plugin_dir_uri( __FILE__ ),
		 *		'my_text_domain'
		 * }
		 * </code>
		 *
		 * @category Models
		 * @package WPMVCBase
		 *
		 * @param string $slug The plugin slug.
		 * @param string $version The plugin version.
		 * @param string $path The plugin directory path.
		 * @param string $file The main plugin file absolute path.
		 * @param string $uri The plugin directory uri.
		 * @param string $txtdomain The plugin text domain.
		 * @access public
		 * @since 0.1
		 */
		public function __construct( $slug, $version, $file, $path, $uri, $txtdomain )
		{
			$this->slug                     = $slug;
			$this->version					= $version;
			$this->main_plugin_file			= $file;
			$this->path						= trailingslashit( $path );
			$this->app_path					= $this->path . 'app/';
			$this->app_controllers_path		= $this->app_path . 'controllers/';
			$this->app_models_path			= $this->app_path . 'models/';
			$this->app_views_path			= $this->app_path . 'views/';
			$this->base_path				= trailingslashit( dirname( dirname( __FILE__ ) ) );
			$this->base_controllers_path	= $this->base_path . 'controllers/';
			$this->base_models_path			= $this->base_path . 'models/';
			$this->base_views_path			= $this->base_path . 'views/';
			$this->uri						= trailingslashit( $uri );
			$this->js_uri					= $this->uri . 'js/';
			$this->css_uri					= $this->uri . 'css/';
			$this->txtdomain				= $txtdomain;

			require_once( $this->base_path . 'helpers/base_helpers.php' );
		}

		/**
		 * Get the plugin slug.
		 *
		 * @return string $slug
		 * @access public
		 * @since 0.1
		 */
		public function get_slug()
		{
			return $this->slug;
		}

		/**
		 * Get the plugin version.
		 *
		 * @return string The plugin version.
		 * @access public
		 * @since 0.1
		 */
		public function get_version()
		{
			return $this->version;
		}
		
		/**
		 * Get the main plugin file.
		 *
		 * @return string The absolute path to the main plugin file.
		 * @access public
		 * @deprecated
		 * @since 0.1
		 */
		public function main_plugin_file()
		{
			Helper_Functions::deprecated( __FUNCTION__, 'get_main_plugin_file', $this->txtdomain );

			return $this->main_plugin_file;
		}

		/**
		 * Get the main plugin file.
		 *
		 * @return string The absolute path to the main plugin file.
		 * @access public
		 * @since 0.1
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
		 * @since 0.1
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
		 * @since 0.1
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
		 * @since 0.1
		 */
		public function get_app_controllers_path()
		{
			return $this->app_controllers_path;
		}
		
		/**
		 * Get the plugin app models path.
		 *
		 * @return string $app_models_path
		 * @access public
		 * @since 0.1
		 */
		public function get_app_models_path()
		{
			return $this->app_models_path;
		}
		
		/**
		 * Get the plugin app views path.
		 *
		 * @return string $app_views_path
		 * @since 0.1
		 */
		public function get_app_views_path()
		{
			return $this->app_views_path;
		}
		
		/**
		 * Get the plugin base path.
		 *
		 * @return string $base_path
		 * @access public
		 * @since 0.1
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
		 * @since 0.1
		 */
		public function get_base_controllers_path()
		{
			return $this->base_controllers_path;
		}
		
		/**
		 * Get the plugin base models path.
		 *
		 * @return string $base_models_path
		 * @access public
		 * @since 0.1
		 */
		public function get_base_models_path()
		{
			return $this->base_models_path;
		}
		
		/**
		 * Get the plugin base views path.
		 *
		 * @return string $base_views_path
		 * @access public
		 * @since 0.1
		 */
		public function get_base_views_path()
		{
			return $this->base_views_path;
		}
		
		/**
		 * Get the plugin uri.
		 *
		 * @return string The plugin uri.
		 * @since 0.1
		 */
		public function get_uri()
		{
			return $this->uri;
		}

		/**
		 * Get the plugin text domain
		 *
		 * @return string $txtdomain
		 * @access public
		 * @since 0.1
		 */
		public function get_textdomain()
		{
			return $this->txtdomain;
		}
	}
endif;
