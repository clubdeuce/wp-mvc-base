<?php

/**
 * The metabox object model.
 * 
 * @author Daryl Lozupone <daryl@actionhook.com>
 *
 */

if ( ! class_exists( 'Base_Model_Metabox' ) ):
	/**
	 * The base metabox object model.
	 *
	 * Example:
	 * <code>
	 * $sample_metabox = new Base_Model_Metabox( 
	 *		'sample_metabox', 
	 *		__( 'Sample Metabox', 'mytextdomain' ),
	 *		'my_callback', //set this to null to use default plugin render_metabox callback
	 *		'post', 
	 *		'normal', 
	 *		'default' 
	 * );
	 * $sample_metabox->add();
	 * </code> 
	 *
	 * @package WPMVCBase\Models
	 * @version 0.1
	 * @since WPMVCBase 0.1
	 */
	class Base_Model_Metabox
	{
		/**
		 * The metabox id
		 * 
		 * HTML 'id' attribute of the edit screen section
		 *
		 * @var string
		 * @since 0.1
		 */
		private $id = 'sample_metabox';
		
		/**
		 * The metabox title
		 *
		 * Title of the edit screen section, visible to user
		 * 
		 * @package WPMVCBase\Models
		 * @var string
		 * @since 0.1
		 */
		private $title = 'Sample Metabox';
		
		/**
		 * the metabox callback
		 *
		 * Function that prints out the HTML for the edit screen section. The function name as a string, or, within a class, an array to call one of the class's methods.
		 * The callback function will recieve up to two parameters, the post object and the Base_Model_Metabox->callback_args.
		 * @package WPMVCBase\Models
		 * @var string
		 * @since 0.1
		 */
		private $callback;
		
		/**
		 * the post type to which this metabox applies
		 *
		 * The type of Write screen on which to show the edit screen section ('post', 'page', 'link', 'attachment' or 'custom_post_type' where custom_post_type is the custom post type slug)
		 * @package WPMVCBase\Models
		 * @var string
		 * @since 0.1
		 */
		private $post_type = 'post';
		
		/**
		 * the metabox context
		 * 
		 * The part of the page where the edit screen section should be shown. 
		 * Valid values are 'normal', 'advanced', or 'side'.
		 *
		 * @var string
		 * @since 0.1
		 */
		private $context = 'normal';
		
		/**
		 * the metabox priority
		 *
		 * The priority within the context where the boxes should be shown.
		 * Valid values are 'high', 'core', 'default', or 'low'.
		 * 
		 * @package WPMVCBase\Models
		 * @var string
		 * @since 0.1
		 */
		private $priority = 'default';
		
		/**
		 * the metabox callback arguments
		 * 
		 * Arguments to pass into your callback function. The callback will receive the $post object and
		 * whatever parameters are passed through this variable.
		 *
		 * Example:
		 
		 * Setting the callback args:
		 * <code>
		 * $sample_metabox->callback_args = array( 'foo' => 'this', "bar => 'that' );
		 * </code>
		 *
		 * The metabox callback:
		 * <code>
		 * // $post is an object containing the current post (as a $post object)
		 * // $metabox is an array with metabox id, title, callback, and args elements. 
		 * // The args element is an array containing your passed $callback_args variables.
		 *
		 * function my_metabox_callback ( $post, $metabox ) {
		 *    echo 'Last Modified: '.$post->post_modified;        // outputs last time the post was modified
		 *    echo $metabox['args']['foo'];                         // outputs 'this'
		 *    echo $metabox['args']['bar'];                         // outputs 'that'
		 *    echo get_post_meta($post->ID,'my_custom_field',true); // outputs value of custom field
		 * }
		 * </code>
		 *
		 * @var array
		 * @since 0.1
		 */
		private $callback_args = array();
		
		/**
		 * the class constructor
		 *
		 * @param string $id
		 * @param string $title
		 * @param string $callback
		 * @param string $post_type
		 * @param string $context
		 * @param string $priority
		 * @param array $callback_args
		 * @return void
		 * @since 0.1
		 */
		public function __construct( $id, $title, $callback, $post_type, $context, $priority, $callback_args )
		{
			$this->id = $id;
			$this->title = $title;
			$this->callback = $callback;
			$this->post_type = $post_type;
			$this->context = $context;
			$this->priority = $priority;
			$this->callback_args = $callback_args;
		}
		
		/**
		 * Add the metabox
		 *
		 * @return void
		 * @since 0.1
		 */
		public function add()
		{
			add_meta_box(
				$this->id,
				$this->title,
				$this->callback,
				$this->post_type,
				$this->context,
				$this->priority,
				$this->callback_args
			);
		}
		
		/**
		 * remove the metabox
		 *
		 * @return void
		 * @since 0.1
		 */
		public function remove()
		{
			remove_meta_box( $this->id, $this->post_type, $this->context );
		}
		
		/**
		 * set the id
		 *
		 * @param string $id
		 * @return void
		 * @since 0.1
		 */
		public function set_id( $id )
		{
			$this->id = $id;
		}
		
		/**
		 * set the title
		 *
		 * @param string $title
		 * @return void
		 * @since 0.1
		 */
		public function set_title( $title )
		{
			$this->title = $title;
		}
		
		/**
		 * set the callback function
		 *
		 * @param string $callback
		 * @return void
		 * @since 0.1
		 */
		public function set_callback( $callback )
		{
			$this->callback = $callback;
		}
		
		/**
		 * set the title
		 *
		 * @param string $post_type
		 * @return void
		 * @since 0.1
		 */
		public function set_post_type( $post_type )
		{
			$this->post_type = $post_type;
		}
		
		/**
		 * set the context
		 *
		 * @param string $context
		 * @return void
		 * @since 0.1
		 */
		public function set_context( $context )
		{
			$this->context = $context;
		}
		
		
		/**
		 * set the priority
		 *
		 * @param string $priority
		 * @return void
		 * @since 0.1
		 */
		public function set_priority( $priority )
		{
			$this->priority = $priority;
		}
		
		/**
		 * set the callback_args
		 *
		 * @param array $callback_args
		 * @return void
		 * @since 0.1
		 */
		public function set_callback_args( $callback_args )
		{
			$this->callback_args = $callback_args;
		}
		
		/**
		 * get the metabox id
		 *
		 * @return string $id
		 * @since 0.1
		 */
		public function get_id()
		{
			return $this->id;
		}
		
		/**
		 * get the metabox title
		 *
		 * @return string $id
		 * @since 0.1
		 */
		public function get_title()
		{
			return $this->title;
		}
		
		/**
		 * get the metabox callback
		 *
		 * @return string $callback
		 * @since 0.1
		 */
		public function get_callback()
		{
			return $this->callback;
		}
		
		/**
		 * get the metabox post_type
		 *
		 * @return string $post_type
		 * @since 0.1
		 */
		public function get_post_type()
		{
			return $this->post_type;
		}
		
		/**
		 * get the metabox context
		 *
		 * @return string $context
		 * @since 0.1
		 */
		public function get_context()
		{
			return $this->context;
		}
		
		/**
		 * get the metabox priority
		 *
		 * @return string $priority
		 * @since 0.1
		 */
		public function get_priority()
		{
			return $this->priority;
		}
		
		/**
		 * get the metabox callback_args
		 *
		 * @return array $callback_args
		 * @since 0.1
		 */
		public function get_callback_args()
		{
			return $this->callback_args;
		}
	}
endif;
 
?>