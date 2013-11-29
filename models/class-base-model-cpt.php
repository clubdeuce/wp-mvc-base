<?php

/**
 * the base CPT class model
 *
 * @author Daryl Lozupone <daryl@actionhook.com>
 */

require_once 'class-base-model.php';

if ( ! class_exists( 'Base_Model_CPT' ) && class_exists( 'Base_Model' ) ):
	/**
	 * The base CPT object model.
	 *
	 * @package WPMVCBase\Models
	 * @version 0.2
	 * @since WPMVCBase 0.1
	 */
	class Base_Model_CPT extends Base_Model
	{
		/**
		 * The cpt slug. Used to register the post type.
		 *
		 * @var string
		 * @access protected
		 * @since 0.1
		 */
		protected $_slug;
		
		/**
		 * The cpt singular name, e.g. Book.
		 *
		 * @var string
		 * @access protected
		 * @since 0.3
		 */
		protected $_singular;
		
		/**
		 * The cpt plural name, e.g. Books.
		 *
		 * @var string
		 * @access protected
		 * @since 0.3
		 *
		 */
		protected $_plural;
		
		/**
		 * The cpt metakey.
		 *
		 * @var array
		 * @access protected
		 * @since 0.1
		 */
		protected $_metakey;
		
		/**
		 * The CPT labels.
		 * 
		 * @var array
		 * @access protected
		 * @since 0.1
		 */
		protected $_labels;
		
		/**
		 * The arguments passed to register_post_type.
		 *
		 * @var array
		 * @access protected
		 * @since 0.1
		 * @link http://codex.wordpress.org/Function_Reference/register_post_type#Arguments
		 */
		protected $_args;
	
		/**
		 * The CPT post updated/deleted/etc messages.
		 *
		 * @var array
		 * @access protected
		 * @since 0.1
		 * @link http://codex.wordpress.org/Function_Reference/register_post_type
		 */
		protected $_messages;
	
		/**
		 * The class constructor.
		 *
		 * Use this function to initialize class variables, require necessary files, etc.
		 *
		 * @param string $slug The post type slug.
		 * @param string $singular The singular post type name in lower case (e.g. Book).
		 * @param string $plural The plural post type name in lower case (e.g. Books).
		 * @param string $uri The plugin uri.
		 * @param string $txtdomain The plugin text domain.
		 * @return void
		 * @access public
		 * @since 0.1
		 */
		public function __construct( $slug, $singular, $plural, $uri = '', $txtdomain = 'wpmvcb' )
		{
			$this->_slug     = $slug;
			$this->_singular = $singular;
			$this->_plural   = $plural;
			$this->_uri      = $uri;
	
			$this->_init_labels( $txtdomain );
			
			if ( method_exists( $this, 'init' ) ) {
				$this->init();
			}
		}
		/**
		 * Initialize the CPT labels property.
		 *
		 * @return void
		 * @since 0.1
		 */
		protected function _init_labels( $txtdomain )
		{
			$this->_labels = array(
				'name'                => $this->_plural,
				'singular_name'       => $this->_singular,
				'menu_name'           => $this->_plural,
				'parent_item_colon'   => sprintf( __( 'Parent %s', $txtdomain ), $this->_singular ),
				'all_items'           => sprintf( __( 'All %s', $txtdomain ), $this->_plural ),
				'view_item'           => sprintf( __( 'View %s', $txtdomain ), $this->_singular ),
				'add_new_item'        => sprintf( __( 'Add New %s', $txtdomain ), $this->_singular ),
				'add_new'             => sprintf( __( 'New %s', $txtdomain ), $this->_singular ),
				'edit_item'           => sprintf( __( 'Edit %s', $txtdomain ), $this->_singular ),
				'update_item'         => sprintf( __( 'Update %s', $txtdomain ), $this->_singular ),
				'search_items'        => sprintf( __( 'Search %s', $txtdomain ), $this->_plural ),
				'not_found'           => sprintf( __( 'No %s found', $txtdomain ), strtolower( $this->_plural ) ),
				'not_found_in_trash'  => sprintf( __( 'No %s found in Trash', $txtdomain ), strtolower( $this->_plural ) ),
			);
		}
		
		/**
		 * Get the singular label
		 *
		 * @return string $_singular
		 * @since WPMVCBase 0.3
		 */
		public function get_singular()
		{
			return $this->_singular;
		}
		
		/**
		 * Get the plural label.
		 *
		 * @return string $_plural
		 * @since WPMVCBase 0.3
		 */
		public function get_plural()
		{
			return $this->_plural;
		}
		
		/**
		 * get the cpt slug
		 *
		 * @return string $_slug
		 * @access public
		 * @since 0.1
		 */
		public function get_slug()
		{
			return $this->_slug;
		}
	
		/**
		 * Get the cpt arguments.
		 *
		 * If this property is not explicitly set in the child class, some default values will be returned.
		 * @return array $_args
		 * @access public
		 * @since 0.1
		 */
		public function get_args()
		{
			if ( isset( $this->_args ) ) {
				return $this->_args;
			}
			
			return array(
				'description'         	=> $this->_plural,
				'labels'              	=> $this->_labels,
				'supports'            	=> array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
				'hierarchical'        	=> false,
				'public'              	=> true,
				'show_ui'             	=> true,
				'show_in_menu'        	=> true,
				'show_in_nav_menus'   	=> true,
				'show_in_admin_bar'   	=> true,
				'menu_icon'           	=> null,
				'can_export'          	=> true,
				'has_archive'         	=> true,
				'exclude_from_search' 	=> false,
				'publicly_queryable'  	=> true,
				'rewrite' 			  	=> array( 'slug' => $this->_slug ),
			);
		}
	
		/**
		 * Get the cpt metakey.
		 *
		 * @return string $_metakey
		 * @return string $metakey
		 * @access public
		 * @since 0.1
		 */
		public function get_metakey()
		{
			if ( ! isset( $this->_metakey ) ) {
				trigger_error( sprintf( __( 'Metakey is not set for %s', 'wpmvcb' ), $this->_slug ), E_USER_WARNING );
			}
	
			return $this->_metakey;
		}
	
		public function set_metakey( $metakey )
		{
			$this->_metakey = $metakey;
		}
		
		/**
		 * Set the $args property
		 *
		 * @param array $args
		 * @return bool|void TRUE on success.
		 * @since 0.1
		 */
		public function set_args( $args )
		{
			if ( ! is_array( $args ) ) {
				trigger_error( sprintf( __( '%s expects an array', 'wpmvcb' ), __FUNCTION__ ), E_USER_WARNING );	
			}
			
			$this->_args = $args;
			return true;
		}
	}
endif;
