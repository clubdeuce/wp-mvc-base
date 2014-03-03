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

include_once 'class-base-model.php';

if ( ! class_exists( 'Base_Model_Plugin' ) ):
	/**
	 * The base plugin model
	 *
	 * @package WPMVCBase\Models
	 * @version 0.2
	 * @since   WPMVCBase 0.2
	 */
	abstract class Base_Model_Plugin extends Base_Model
	{
		/**
		 * The plugin slug.
		 *
		 * @var    string
		 * @access protected
		 * @since  WPMVCBase 0.2
		 */
		protected $slug;

		/**
		 * The plugin version.
		 *
		 * @var    string
		 * @access protected
		 * @since  WPMVCBase 0.2
		 */
		protected $version;

		/**
		 * The plugin custom post types.
		 *
		 * @var    array Contains an array of cpt controller objects
		 * @access protected
		 * @since  WPMVCBase 0.2
		 */
		protected $cpts;

		/**
		 * The plugin settings model.
		 *
		 * @var    object
		 * @access protected
		 * @since  WPMVCBase 0.2
		 */
		protected $settings_model;

		/**
		 * The nonce name to be used for plugin form submissions.
		 *
		 * @var    string
		 * @access protected
		 * @since  WPMVCBase 0.2
		 */
		protected $nonce_name;

		/**
		 * The nonce action to be used for plugin form submissions.
		 *
		 * @var    string
		 * @access protected
		 * @since  WPMVCBase 0.2
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
		 *		__FILE__,
		 *		plugin_dir_path( __FILE__ ),
		 *		plugin_dir_uri( __FILE__ ),
		 *		'my_text_domain'
		 * }
		 * </code>
		 *
		 * @param  string $slug         The plugin slug.
		 * @param  string $version      The plugin version.
		 * @param  string $file         The main plugin file absolute path.
		 * @param  string $plugin_path  The plugin directory path.
		 * @param  string $app_path     The plugin app path.
		 * @param  string $base_path    The plugin base path.
		 * @param  string $uri          The plugin directory uri.
		 * @param  string $txtdomain    The plugin text domain.
		 * @access public
		 * @since  WPMVCBase 0.2
		 */
		public function __construct( $slug, $version, $file, $plugin_path, $app_path, $base_path, $uri, $txtdomain )
		{
			parent::__construct( $file, $plugin_path, $app_path, $base_path, $uri, $txtdomain );
			$this->slug             = $slug;
			$this->version          = $version;
			$this->js_uri           = $this->uri . 'js/';
			$this->css_uri          = $this->uri . 'css/';
		}
		
		/**
		 * Get the plugin slug.
		 *
		 * @return string $slug
		 * @access public
		 * @since  WPMVCBase 0.2
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
		 * @since  WPMVCBase 0.2
		 */
		public function get_version()
		{
			return $this->version;
		}
	}
endif;
