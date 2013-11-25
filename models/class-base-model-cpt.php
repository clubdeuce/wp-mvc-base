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
			
			if ( ! method_exists( $this, 'init' ) ) {
				trigger_error( __( 'Your child CPT model %s does not have a method init(). Please implement this method and set your CPT arguments ( passed to WordPress register_post_type as the $args parameter ) as well as any custom actions, etc.', 'wpmvcb' ), E_USER_WARNING );
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
		 * Get the CPT messages
		 *
		 * @param object $post The WP post object.
		 * @return array $_messages The messages array.
		 * @access public
		 * @since 0.1
		 */
		public function get_post_updated_messages( $post, $txtdomain )
		{
			$messages = array(
				0 => null, // Unused. Messages start at index 1.
				1 => sprintf(
					__( '%1$s updated. <a href="%3$s">View %2$s</a>', $txtdomain ),
					$this->_singular,
					strtolower( $this->_singular ),
					esc_url( get_permalink( $post->ID ) )
				),
				2 => __( 'Custom field updated.', $txtdomain ),
				3 => __( 'Custom field deleted.', $txtdomain ),
				4 => sprintf( __( '%s updated.', $this->_txtdomain ), $this->_singular ),
				/* translators: %2$s: date and time of the revision */
				5 => isset( $_GET['revision'] ) ? sprintf( __( '%1$s restored to revision from %s', $this->_txtdomain ), $this->_singular, wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
				6 => sprintf( __( '%s published. <a href="%s">View book</a>', $this->_txtdomain ), $this->_singular, esc_url( get_permalink( $post->ID ) ) ),
				7 => sprintf( __( '%s saved.', $this->_txtdomain ), $this->_singular ),
				8 => sprintf(
					__( '%1$s submitted. <a target="_blank" href="%3$s">Preview %2$s</a>', $this->_txtdomain ),
					$this->_singular,
					strtolower( $this->_singular ),
					esc_url( add_query_arg( 'preview', 'true', get_permalink( $post->ID ) ) )
				),
				9 => sprintf(
					__( '%3$s scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview %4$s</a>', $this->_txtdomain ),
					// translators: Publish box date format, see http://php.net/date
					date_i18n( __( 'M j, Y @ G:i' ), strtotime( $this->_post->post_date ) ),
					esc_url( get_permalink( $post->ID ) ),
					$this->_singular,
					strtolower( $this->_singular )
				),
				10 => sprintf(
					__( '%1$s draft updated. <a target="_blank" href="%3$s">Preview %2$s</a>', $this->_txtdomain ),
					$this->_singular,
					strtolower( $this->_singular ),
					esc_url( add_query_arg( 'preview', 'true', get_permalink( $post->ID ) ) )
				)
			);
	
			return $messages;
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
