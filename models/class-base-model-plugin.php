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

include_once 'class-base-model.php';

if ( ! class_exists( 'Base_Model_Plugin' ) ):
	/**
	 * The base plugin model
	 *
	 * @package WPMVCBase\Models
	 * @version 0.2
	 * @since 0.2
	 */
	abstract class Base_Model_Plugin extends Base_Model
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
		 * The plugin custom post types.
		 *
		 * @var array Contains an array of cpt controller objects
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
		 * @param string $slug         The plugin slug.
		 * @param string $version      The plugin version.
		 * @param string $file         The main plugin file absolute path.
		 * @param string $plugin_path  The plugin directory path.
		 * @param string $app_path     The plugin app path.
		 * @param string $base_path    The plugin base path.
		 * @param string $uri          The plugin directory uri.
		 * @param string $txtdomain    The plugin text domain.
		 * @access public
		 * @since 0.1
		 */
		public function __construct( $slug, $version, $file, $plugin_path, $app_path, $base_path, $uri, $txtdomain )
		{
			parent::__construct( $file, $plugin_path, $app_path, $base_path, $uri, $txtdomain );
			$this->slug             = $slug;
			$this->version          = $version;
			$this->js_uri           = $this->uri . 'js/';
			$this->css_uri          = $this->uri . 'css/';
			
			if ( ! class_exists( 'Helper_Functions' ) ) {
				require_once(  $this->base_path . '/helpers/class-base-helpers.php' );
			}
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
	}
endif;
