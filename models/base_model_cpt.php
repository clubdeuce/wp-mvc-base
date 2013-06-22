<?php

/**
 * the base CPT class model
 *
 * @author Daryl Lozupone <daryl@actionhook.com>
 */

require_once( 'base_model.php' );

if ( ! class_exists( 'Base_Model_CPT' ) && class_exists( 'Base_Model' ) ):
	/**
	 * The base CPT object model.
	 *
	 * @package WPMVCBase\Models
	 * @version 0.1
	 * @abstract
	 * @since WPMVCBase 0.1
	 */
	 abstract class Base_Model_CPT extends Base_Model
	 {
	 	/**
		 * The cpt slug.
		 *
		 * @var string
		 * @access protected
		 * @since 0.1
		 */
		protected $slug;
		
		/**
		 * The cpt metakey .
		 *
		 * @var array
		 * @access protected
		 * @since 0.1
		 */
		protected $metakey;
		
		/**
		 * The arguments passed to register_post_type.
		 *
		 * @var array
		 * @access protected
		 * @since 0.1
		 * @link http://codex.wordpress.org/Function_Reference/register_post_type#Arguments
		 */
		protected $args;
		
		/**
		 * The CPT post updated/deleted/etc messages.
		 * 
		 * @var array
		 * @access protected
		 * @since 0.1
		 * @link http://codex.wordpress.org/Function_Reference/register_post_type
		 */
		protected $messages;
		
		/**
		 * Shortcodes exposed by this CPT.
		 *
		 * This property is an array of key/value pairs of the shortcode name and the callback function.
		 * Example:
		 * <code>
		 * $this->shortcodes = array( 'myshortcode' => 'myshortcode_callback_function );
		 * </code>
		 *
		 * @var array
		 * @access protected
		 * @since 0.1
		 */
		protected $shortcodes;
		
		/**
		 * The Help screen tabs for this CPT
		 *
		 * This property is an array containing individual help screen definitions.
		 * Example:
		 * <code>
		 * $help_tabs = array(  'title' => __( 'My Help Screen', 'my_text_domain' ), 'id' => 'demo-help', 'call' => 'my_callback_function' );
		 * </code>
		 * @var array
		 * @access protected
		 * @since 0.1
		 */
		protected $help_tabs;
		
		/**
		 * The class constructor.
		 *
		 * Use this function to initialize class variables, require necessary files, etc.
		 *
		 * @param string $uri The plugin uri.
		 * @param string $txtdomain The plugin text domain.
		 * @return void
		 * @access public
		 * @since 0.1
		 */
		public function __construct( $uri, $txtdomain )
		{
			if ( method_exists( $this, 'init' ) )
				$this->init( $uri, $txtdomain );
				
			if ( method_exists( $this, 'init_args' ) )
				$this->init_args( $txtdomain );
			
			if ( method_exists( $this, 'init_shortcodes' ) )
	 			$this->init_shortcodes();
		}
		
		
		/**
		 * Get the CPT messages
		 *
		 * @param object $post The WP post object.
		 * @param string $txtdomain The text domain to use for localization.
		 * @return array $messages The messages array.
		 * @access public
		 * @since 0.1
		 */
		public function get_post_updated_messages( $post, $txtdomain ) 
		{
			
			$messages = array(
				0 => null, // Unused. Messages start at index 1.
				1 => sprintf( __('Book updated. <a href="%s">View book</a>', 'your_text_domain'), esc_url( get_permalink($post_ID) ) ),
				2 => __('Custom field updated.', 'your_text_domain'),
				3 => __('Custom field deleted.', 'your_text_domain'),
				4 => __('Book updated.', 'your_text_domain'),
				/* translators: %s: date and time of the revision */
				5 => isset($_GET['revision']) ? sprintf( __('Book restored to revision from %s', 'your_text_domain'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
				6 => sprintf( __('Book published. <a href="%s">View book</a>', 'your_text_domain'), esc_url( get_permalink($post_ID) ) ),
				7 => __('Book saved.', 'your_text_domain'),
				8 => sprintf( __('Book submitted. <a target="_blank" href="%s">Preview book</a>', 'your_text_domain'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
				9 => sprintf( __('Book scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview book</a>', 'your_text_domain'),
				  // translators: Publish box date format, see http://php.net/date
				  date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
				10 => sprintf( __('Book draft updated. <a target="_blank" href="%s">Preview book</a>', 'your_text_domain'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) )
			);
		
			return $messages;
		}
		/**
		 * get the cpt slug
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
		 * Get the cpt arguments.
		 *
		 * @param string $txtdomain The plugin text domain.
		 * @return array $args
		 * @access public
		 * @since 0.1
		 */
		public function get_args( $txtdomain )
		{				
			if( ! isset( $this->args ) )
				$this->init_args( $txtdomain );
			
			return $this->args;
		}
		
		/**
		 * Get the cpt shortcodes.
		 *
		 * @return array $shortcodes
		 * @access public
		 * @since 0.1
		 */
		public function get_shortcodes()
		{				
			if( ! isset( $this->shortcodes ) && method_exists( $this, 'init_shortcodes' ) )
				$this->init_shortcodes();
			
			return $this->shortcodes;
		}
		
		/**
		 * Get the cpt help screen tabs.
		 *
		 * @param string $path The plugin app views path.
		 * @param string $txtdomain The plugin text domain.
		 * @return array $help_screen Contains the help screen tab objects.
		 * @access public
		 * @since 0.1
		 */
		public function get_help_screen( $path, $txtdomain )
		{
			if( ! isset( $this->help_screen ) && method_exists( $this, 'init_help_screen' ) )
				$this->init_help_screen( $path, $txtdomain );
			
			return $this->help_screen;
		}
		
		/**
		 * Register this post type.
		 *
		 * @param string $uri The plugin uri.
		 * @param string $txtdomain The plugin text domain.
		 * @return object The registered post type object on success, WP_Error object on failure
		 * @access public
		 * @since 0.1
		 */
		public function register( $uri, $txtdomain )
		{
			if ( ! isset( $this->args ) )
				$this->init_args( $uri, $txtdomain );
			
			return register_post_type( $this->slug, $this->args );
		}
		
		/**
		 * Get the cpt meta key.
		 *
		 * @return string $metakey
		 * @return void
		 * @static
		 * @access public
		 * @since 0.1
		 */
		public function get_metakey()
		{
			return $this->metakey;
		}
				
		/**
		 * Save the cpt.
		 *
		 * @param array $post_data the POSTed data
		 * @abstract
		 * @since 0.1
		 */
		abstract public function save( $post_data );

	 }
endif;

?>