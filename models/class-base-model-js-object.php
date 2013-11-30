<?php
/**
 * The base javascript object model.
 *
 * @author Daryl Lozupone <daryl@actionhook.com>
 * @version 0.1
 * @since WPMVCBase 0.1
 */
if ( ! class_exists( 'Base_Model_JS_Object' ) ):
	/**
	 * The base javascript object model.
	 *
	 * Example:
	 * <code>
	 * $script = new Base_Model_JS_Object(
	 * 		'my-script'
	 * 		'http://example.com/wp-content/plugins/my-plugin/js/my-script.js',
	 * 		array( 'jquery', 'jquery-ui' ),
	 * 		'5.4.17'
	 * 		false,
	 * 		'myscriptl10n',
	 *		array( 'errorMessage' => __( 'There was an error.', 'mytxtdomain')
	 * );
	 * </code>
	 *
	 * This class exposes two filters, ah_base_filter_script_src-$handle and ah_base_filter_script_localization_args-$handle.
	 * These are included to allow the plugin controller to modify these elements immediately prior to enqueuing of the script.
	 *
	 * Example:
	 * <code>
	 * public function filter_script_source( $source )
	 * {
	 * 		$source = 'http://example.com/wp-content/plugins/my-plugin/js/my-script.min.js';
	 * 		return $source;
	 * }
	 * add_filter( 'ah_base_filter_script_src-my-script', 'filter_script_source' );
	 *
	 * public function filter_script_localization( $args )
	 * {
	 * 		$args['my_arg'] = 'foo';
	 * 		return $args;
	 * }
	 * add_filter( 'ah_base_filter_script_localization_args-my-script', 'filter_script_localization' );
	 * </code>
	 *
	 * If using a script already registered by WordPress, you need only specify the handle.
	 *
	 * @package WPMVCBase\Models
	 * @since WPMVCBase 0.1
	 */
	class Base_Model_JS_Object
	{
		/**
		 * The script handle.
		 *
		 * Name used as a handle for the script. As a special case, if the string contains a '?' character,
		 * the preceding part of the string refers to the registered handle, and the succeeding part is
		 * appended to the URL as a query string.
		 *
		 * @var string
		 * @since 0.1
		 */
		private $_handle;

		/**
		 * The script source uri.
		 *
		 * URL to the script, e.g. http://example.com/wp-content/themes/my-theme/my-theme-script.js.
		 * You should never hardcode URLs to local scripts. To get a proper URL to local scripts, use plugins_url()
		 * for plugins and get_template_directory_uri() for themes. Remote scripts can be specified with a protocol-agnostic
		 * URL, e.g. //otherdomain.com/js/their-script.js. This parameter is only required when the script with the given
		 * $handle has not been already registered using wp_register_script().
		 *
		 * @var string
		 * @since 0.1
		 */
		private $_src;

		/**
		 * The script dependencies.
		 *
		 * Array of the handles of all the registered scripts upon which this script depends, that is the scripts that must be
		 * loaded before this script. Set false if there are no dependencies.
		 *
		 * @var array
		 * @since 0.1
		 */
		private $_deps;

		/**
		 * The script version number.
		 *
		 * String specifying the script version number, if it has one, which is concatenated to the end of the path as a query string.
		 * If no version is specified or set to false, then WordPress automatically adds a version number equal to the current version
		 * of WordPress you are running. If set to null no version is added. This parameter is used to ensure that the correct version
		 * is sent to the client regardless of caching, and so should be included if a version number is available and makes sense for the script.
		 *
		 * @var string|bool
		 * @since 0.1
		 */
		private $_version;

		/**
		 * Script placement.
		 *
		 * Normally, scripts are placed in <head> of the HTML document. If this parameter is true, the script is placed before the </body> end tag.
		 *
		 * @var bool
		 * @since 0.1
		 */
		private $_in_footer;

		/**
		 * The localization variable name.
		 *
		 * String specifying the localization variable name to be used in the wp_localize_script() function. If set, the $localization_args property
		 * is required and this class will attempt to localize the script immediately after enqueuing the script.
		 *
		 * @var string
		 * @since 0.1
		 */
		private $_localization_var;

		/**
		 * The localization arguments.
		 *
		 * An array of key/value pairs containing the argument name(s) and value(s).
		 * If the $localization_var property is set, this will be used as the $args parameter of the wp_localize_script function.
		 *
		 * @var array
		 * @since 0.1
		 */
		private $_localization_args;

		/**
		 * The class constructor
		 *
		 * @param string $handle
		 * @param string $src
		 * @param array $deps
		 * @param string|bool $version
		 * @param bool $in_footer
		 * @param string $localization_var
		 * @param array $localization_args
		 * @since 0.1
		 */
		public function __construct( $handle, $src = false, $deps = array(), $version = false, $in_footer = false, $localization_var = null, $localization_args = null )
		{
			$this->_handle            = $handle;
			$this->_src               = $src;
			$this->_deps              = $deps;
			$this->_version           = $version;
			$this->_in_footer         = $in_footer;
			$this->_localization_var  = $localization_var;
			$this->_localization_args = $localization_args;
		}

		/**
		 * Register the script.
		 *
		 * @link http://codex.wordpress.org/Function_Reference/wp_register_script
		 * @return void
		 * @since 0.1
		 */
		public function register()
		{
			wp_register_script( $this->_handle, $this->_src, $this->_deps, $this->_version, $this->_in_footer );
		}

		/**
		 * Enqueue the script.
		 *
		 * @link http://codex.wordpress.org/Function_Reference/wp_enqueue_script
		 * @return void
		 * @since 0.1
		 */
		public function enqueue()
		{
			//apply filters
			$this->_src = apply_filters( 'ah_base_filter_script_src-' . $this->_handle, $this->_src );
			$this->_localization_args = apply_filters( 'ah_base_filter_script_localization_args-' . $this->_handle, $this->_localization_args );

			wp_enqueue_script( $this->_handle, $this->_src, $this->_deps, $this->_version, $this->_in_footer );
			if ( isset( $this->_localization_var ) && isset( $this->_localization_args ) ) {
				$this->localize();
			}
		}

		/**
		 * Localize the script
		 *
		 * @link http://codex.wordpress.org/Function_Reference/wp_localize_script
		 * @return bool TRUE on success, FALSE on failure
		 * @since 0.1
		 */
		public function localize()
		{
			if ( isset( $this->_localization_var ) && isset( $this->_localization_args ) ) {
				return wp_localize_script( $this->_handle, $this->_localization_var, $this->_localization_args );
			}
			
			return false;
		}

		/**
		 * Dequeue the script.
		 *
		 * @link http://codex.wordpress.org/Function_Reference/wp_dequeue_script
		 * @return void
		 * @since 0.1
		 */
		public function dequeue()
		{
			wp_dequeue_script( $this->_handle );
		}

		/**
		 * Deregister the script.
		 *
		 * @link http://codex.wordpress.org/Function_Reference/wp_deregister_script
		 * @return void
		 * @since 0.1
		 */
		public function deregister()
		{
			wp_deregister_script( $this->_handle );
		}
		
		/**
		 * Get the script handle.
		 *
		 * @return string $_handle
		 * @since WPMVCBase 0.3
		 */
		function get_handle()
		{
			return $this->_handle;
		}
		
		/**
		 * Get the script source.
		 *
		 * @return string $_src
		 * @since WPMVCBase 0.3
		 */
		function get_src()
		{
			return $this->_src;
		}
		
		/**
		 * Get the script dependencies.
		 *
		 * @return array $_deps
		 * @since WPMVCBase 0.3
		 */
		function get_deps()
		{
			return $this->_deps;
		}
		
		/**
		 * Get the script version.
		 *
		 * @return string $_version
		 * @since WPMVCBase 0.3
		 */
		function get_version()
		{
			return $this->_version;
		}
		
		/**
		 * Get the script placement.
		 *
		 * @return string $_in_footer
		 * @since WPMVCBase 0.3
		 */
		function get_in_footer()
		{
			return $this->_in_footer;
		}
		
		/**
		 * Get the script localization variable name.
		 *
		 * @return string|bool $_localization_var if set, FALSE if not.
		 * @since WPMVCBase 0.3
		 */
		function get_localization_var()
		{
			if ( isset( $this->_localization_var ) ) {
				return $this->_localization_var;
			}
			
			return false;
		}
		
		/**
		 * Get the script localization arguments.
		 *
		 * @return string|bool $_localization_args if set, FALSE if not.
		 * @since WPMVCBase 0.3
		 */
		function get_localization_args()
		{
			if ( isset( $this->_localization_args ) ) {
				return $this->_localization_args;
			}
			
			return false;
		}
	}
endif;
