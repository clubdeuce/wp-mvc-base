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

require_once 'class-base-model.php';

if ( ! class_exists( 'Base_Model_CPT' ) && class_exists( 'Base_Model' ) ):
	/**
	 * The base CPT object model.
	 *
	 * @package WPMVCBase\Models
	 * @version 0.2
	 * @since   WPMVCBase 0.1
	 */
	abstract class Base_Model_CPT extends Base_Model
	{
		/**
		 * The cpt slug. Used to register the post type.
		 *
		 * @var    string
		 * @access protected
		 * @since  WPMVCBase 0.1
		 */
		protected $slug;
		
		/**
		 * The cpt singular name, e.g. Book.
		 *
		 * @var    string
		 * @access protected
		 * @since  WPMVCBase 0.2
		 */
		protected $singular;
		
		/**
		 * The cpt plural name, e.g. Books.
		 *
		 * @var    string
		 * @access protected
		 * @since  WPMVCBase 0.2
		 *
		 */
		protected $plural;
		
		/**
		 * The CPT labels.
		 * 
		 * @var    array
		 * @access protected
		 * @since  WPMVCBase 0.1
		 */
		protected $labels;
		
		/**
		 * The arguments passed to register_post_type.
		 *
		 * @var    array
		 * @access protected
		 * @since  WPMVCBase 0.1
		 * @link   http://codex.wordpress.org/Function_Reference/register_post_type#Arguments
		 */
		protected $args;

		/**
		 * The custom post type description
		 * 
		 * A short descriptive summary of what the post type is. 
		 * 
		 * @var    string
		 * @access protected
		 * @since  0.3.2
		 * @link   http://codex.wordpress.org/Function_Reference/register_post_type#Arguments
		 */
		protected $description = '';

		/**
		 * Public property
		 * 
		 * Whether a post type is intended to be used publicly either via the admin interface or by front-end users.
		 * 
		 * @var    bool
		 * @access protected
		 * @since  0.3.2
		 * @link   http://codex.wordpress.org/Function_Reference/register_post_type#Arguments
		 */
		protected $public = false;

		/**
		 * Whether to exclude posts with this post type from front end search results.
		 * 
		 * @var    bool
		 * @access protected
		 * @since  0.3.2
		 * @link   http://codex.wordpress.org/Function_Reference/register_post_type#Arguments
		 */
		protected $exclude_from_search;

		
		/**
		 * Whether queries can be performed on the front end as part of parse_request().
		 * 
		 * @var    bool
		 * @access protected
		 * @since  0.3.2
		 * @link   http://codex.wordpress.org/Function_Reference/register_post_type#Arguments
		 */
		protected $publicly_queryable;

		/**
		 * Show in admin dashboard?
		 * 
		 * Whether to generate a default UI for managing this post type in the admin.
		 * 
		 * @var    bool
		 * @access protected
		 * @since  0.3.2
		 * @link   http://codex.wordpress.org/Function_Reference/register_post_type#Arguments
		 */
		protected $show_ui;

		/**
		 * The show_in_nav_menus property
		 * 
		 * Whether post_type is available for selection in navigation menus. 
		 * 
		 * @var    bool
		 * @access protected
		 * @since  0.3.2
		 * @link   http://codex.wordpress.org/Function_Reference/register_post_type#Arguments
		 */
		protected $show_in_nav_menus;

		/**
		 * The show_in_menu property
		 * 
		 * Where to show the post type in the admin menu. show_ui must be true.
		 * 
		 * @var    bool|string
		 * @access protected
		 * @since  0.3.2
		 * @link   http://codex.wordpress.org/Function_Reference/register_post_type#Arguments
		 */
		protected $show_in_menu;

		/**
		 * The show_in_menu_bar property
		 * 
		 * Whether to make this post type available in the WordPress admin bar.
		 * 
		 * @var    bool
		 * @access protected
		 * @since  0.3.2
		 * @link   http://codex.wordpress.org/Function_Reference/register_post_type#Arguments
		 */
		protected $show_in_admin_bar;

		/**
		 * The menu_position property
		 * 
		 * Whether to make this post type available in the WordPress admin bar.
		 * 
		 * @var    int
		 * @access protected
		 * @since  0.3.2
		 * @link   http://codex.wordpress.org/Function_Reference/register_post_type#Arguments
		 */
		protected $menu_position = null;

		/**
		 * The menu_icon property
		 * 
		 * The url to the icon to be used for this menu or the name of the icon from the iconfont
		 * 
		 * @var    string
		 * @access protected
		 * @since  0.3.2
		 * @link   http://codex.wordpress.org/Function_Reference/register_post_type#Arguments
		 */
		protected $menu_icon;

		/**
		 * The capability_type property
		 * 
		 * The string to use to build the read, edit, and delete capabilities.
		 * 
		 * @var    string|array
		 * @access protected
		 * @since  0.3.2
		 * @link   http://codex.wordpress.org/Function_Reference/register_post_type#Arguments
		 */
		protected $capability_type;

		/**
		 * The capabilities property
		 * 
		 * The string to use to build the read, edit, and delete capabilities.
		 * 
		 * @var    array
		 * @access protected
		 * @since  0.3.2
		 * @link   http://codex.wordpress.org/Function_Reference/register_post_type#Arguments
		 */
		protected $capabilities;

		/**
		 * The map_meta_cap property
		 * 
		 * Whether to use the internal default meta capability handling.
		 * 
		 * @var    bool
		 * @access protected
		 * @since  0.3.2
		 * @link   http://codex.wordpress.org/Function_Reference/register_post_type#Arguments
		 */
		protected $map_meta_cap = null;

		/**
		 * The hierarchical property
		 * 
		 * Whether the post type is hierarchical (e.g. page). Allows Parent to be specified.
		 * The 'supports' parameter should contain 'page-attributes' to show the parent select box on the editor page. 
		 * 
		 * @var    bool
		 * @access protected
		 * @since  0.3.2
		 * @link   http://codex.wordpress.org/Function_Reference/register_post_type#Arguments
		 */
		protected $hierarchical = null;

		/**
		 * The supports property
		 * 
		 * An alias for calling add_post_type_support() directly. As of WordPress 3.5, boolean false can be
		 * passed as value instead of an array to prevent default (title and editor) behavior. 
		 * 
		 * @var    array|bool
		 * @access protected
		 * @since  0.3.2
		 * @link   http://codex.wordpress.org/Function_Reference/register_post_type#Arguments
		 */
		protected $supports = array( 'title', 'editor' );

		/**
		 * The custom post type metabox callback
		 * 
		 * An alias for calling add_post_type_support() directly. As of WordPress 3.5, boolean false can be
		 * passed as value instead of an array to prevent default (title and editor) behavior. 
		 * 
		 * @var    callback
		 * @access protected
		 * @since  0.3.2
		 * @link   http://codex.wordpress.org/Function_Reference/register_post_type#Arguments
		 */
		protected $register_meta_box_cb;

		/**
		 * The custom post type taxonomies
		 * 
		 * An array of registered taxonomies like category or post_tag that will be used with this post type.
		 * This can be used in lieu of calling register_taxonomy_for_object_type() directly. Custom taxonomies
		 * still need to be registered with register_taxonomy().  
		 * 
		 * @var    array
		 * @access protected
		 * @since  0.3.2
		 * @link   http://codex.wordpress.org/Function_Reference/register_post_type#Arguments
		 */
		protected $taxonomies;

		/**
		 * The has_archive property
		 * 
		 * Enables post type archives. Will use the first parameter passed into register_post_type()
		 * as archive slug by default.   
		 * 
		 * @var    bool|string
		 * @access protected
		 * @since  0.3.2
		 * @link   http://codex.wordpress.org/Function_Reference/register_post_type#Arguments
		 */
		protected $has_archive;

		/**
		 * Enable rewrite for custom post type
		 * 
		 * Triggers the handling of rewrites for this post type. To prevent rewrites, set to false.
		 * Default: true and use $post_type as slug 
		 * 
		 * @var    bool|array
		 * @access protected
		 * @since  0.3.2
		 * @link   http://codex.wordpress.org/Function_Reference/register_post_type#Arguments
		 */
		protected $rewrite;

		/**
		 * The custom post type query_var key
		 * 
		 * Default: true - set to first parameter passed into register_post_type() 
		 * 
		 * @var    string
		 * @access protected
		 * @since  0.3.2
		 * @link   http://codex.wordpress.org/Function_Reference/register_post_type#Arguments
		 */
		protected $query_var;

		/**
		 * Is the post type exportable?
		 * 
		 * Default: true
		 * 
		 * @var    bool
		 * @access protected
		 * @since  0.3.2
		 * @link   http://codex.wordpress.org/Function_Reference/register_post_type#Arguments
		 */
		protected $can_export;

		/**
		 * The CPT post updated/deleted/etc messages.
		 *
		 * @var    array
		 * @access protected
		 * @since  WPMVCBase 0.1
		 * @link   http://codex.wordpress.org/Function_Reference/register_post_type
		 */
		protected $messages;
	
		/**
		 * The class constructor.
		 *
		 * Use this function to initialize class variables, require necessary files, etc.
		 *
		 * @param  string $slug             The post type slug.
		 * @param  string $singular         The singular post type name in lower case (e.g. Book).
		 * @param  string $plural           The plural post type name in lower case (e.g. Books).
		 * @param  string $main_plugin_file The absolute path to the main plugin file.
		 * @param  string $plugin_path      The absolute path to the plugin directory
		 * @param  string $app_path         The absolute path to the plugin app directory.
		 * @param  string $base_path        The absolute path to the plugin base directory.
		 * @param  string $uri              The uri to the plugin app directory.
		 * @param  string $txtdomain        The plugint text domain.
		 * @access public
		 * @since  WPMVCBase 0.1
		 */
		public function __construct( $slug, $singular, $plural, $main_plugin_file, $plugin_path, $app_path, $base_path, $uri, $txtdomain = 'wpmvcb' )
		{
			$this->slug     = $slug;
			$this->singular = $singular;
			$this->plural   = $plural;
			$this->uri      = $uri;
			
			$this->init_labels( $txtdomain );
			
			parent::__construct( $main_plugin_file, $plugin_path, $app_path, $base_path, $uri, $txtdomain );
		}
		
		/**
		 * Initialize the CPT labels property.
		 *
		 * @access protected
		 * @since  WPMVCBase 0.1
		 * @param string $txtdomain
		 */
		protected function init_labels( $txtdomain )
		{
			$this->labels = array(
				'name'                => $this->plural,
				'singular_name'       => $this->singular,
				'menu_name'           => $this->plural,
				'parent_item_colon'   => sprintf( __( 'Parent %s', $txtdomain ), $this->singular ),
				'all_items'           => sprintf( __( 'All %s', $txtdomain ), $this->plural ),
				'view_item'           => sprintf( __( 'View %s', $txtdomain ), $this->singular ),
				'add_new_item'        => sprintf( __( 'Add New %s', $txtdomain ), $this->singular ),
				'add_new'             => sprintf( __( 'New %s', $txtdomain ), $this->singular ),
				'edit_item'           => sprintf( __( 'Edit %s', $txtdomain ), $this->singular ),
				'update_item'         => sprintf( __( 'Update %s', $txtdomain ), $this->singular ),
				'search_items'        => sprintf( __( 'Search %s', $txtdomain ), $this->plural ),
				'not_found'           => sprintf( __( 'No %s found', $txtdomain ), strtolower( $this->plural ) ),
				'not_found_in_trash'  => sprintf( __( 'No %s found in Trash', $txtdomain ), strtolower( $this->plural ) ),
			);
		}
		
		/**
		 * Get the singular label
		 *
		 * @return string $singular
		 * @access public
		 * @since  WPMVCBase 0.2
		 */
		public function get_singular()
		{
			return $this->singular;
		}
		
		/**
		 * Get the plural label.
		 *
		 * @return string $plural
		 * @access public
		 * @since  WPMVCBase 0.2
		 */
		public function get_plural()
		{
			return $this->plural;
		}
		
		/**
		 * get the cpt slug
		 *
		 * @return string $slug
		 * @access public
		 * @since WPMVCBase 0.1
		 */
		public function get_slug()
		{
			return $this->slug;
		}
	
		/**
		 * Get the cpt arguments.
		 *
		 * If this property is not explicitly set in the child class, some default values will be returned.
		 *
		 * @return array $args
		 * @access public
		 * @since  WPMVCBase 0.1
		 */
		public function get_args()
		{
			if ( isset( $this->args ) ) {
				return $this->args;
			}
			
			return array(
				'description'         	=> $this->plural,
				'labels'              	=> $this->labels,
				'supports'            	=> $this->supports,
				'hierarchical'        	=> $this->hierarchical,
				'public'              	=> $this->public,
				'show_ui'             	=> $this->show_ui,
				'show_in_menu'        	=> $this->show_in_menu,
				'show_in_nav_menus'   	=> $this->show_in_nav_menus,
				'show_in_admin_bar'   	=> $this->show_in_admin_bar,
				'menu_icon'           	=> $this->menu_icon,
				'can_export'          	=> $this->can_export,
				'has_archive'         	=> $this->has_archive,
				'exclude_from_search' 	=> $this->exclude_from_search,
				'publicly_queryable'  	=> $this->publicly_queryable,
				'rewrite' 			  	=> $this->rewrite,
			);
		}
		
		/**
		 * Set the $args property
		 *
		 * @param  array $args
		 * @return bool|object TRUE on success, WP_Error object on failure.
		 * @access public
		 * @since  WPMVCBase 0.1
		 */
		public function set_args( $args )
		{	
			if( ! is_array( $args ) ) {
				return new WP_Error( 
					'FAIL',
					sprintf( __( '%s::%s expects an array', 'wpmvcb' ), __CLASS__, __FUNCTION__ ),
					$args
				);
			}
			
			$this->args = $args;
			return true;			
		}
		
		/**
		 * Add a taxonomy to the model.
		 * 
		 * @access public
		 * @param  Base_Model_Taxonomy $taxonomy The taxonomy model.
		 * @since  0.3
		 */
		public function add_taxonomy( Base_Model_Taxonomy $taxonomy )
		{
			$this->taxonomies[ $taxonomy->get_slug() ] = $taxonomy;
		}
		
		/**
		 * Get the taxonomies attached to this model.
		 * 
		 * @access public
		 * @return array  $taxonomies
		 * @since  0.3
		 */
		public function get_taxonomies()
		{
			return $this->taxonomies;
		}
	}
endif;
