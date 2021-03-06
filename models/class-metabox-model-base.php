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

if ( ! class_exists( 'WPMVCB_Metabox_Model_Base' ) ) {
	/**
	 * The base metabox object model.
	 *
	 * @package WPMVCBase\Models
	 * @version 0.1
	 * @since WPMVCBase 0.1
	 */
	class WPMVCB_Metabox_Model_Base
	{
		/**
		 * The metabox id
		 *
		 * HTML 'id' attribute of the edit screen section
		 *
		 * @var    string
		 * @access private
		 * @since  WPMVCBase 0.1
		 */
		private $id = 'sample_metabox';

		/**
		 * The metabox title
		 *
		 * Title of the edit screen section, visible to user
		 *
		 * @var    string
		 * @access private
		 * @since  WPMVCBase 0.1
		 */
		private $title = 'Sample Metabox';

		/**
		 * the metabox callback
		 *
		 * Function that prints out the HTML for the edit screen section. The function name as a string, or, 
		 * within a class, an array to call one of the class's methods. The callback function will 
		 * recieve up to two parameters, the post object and the Base_Model_Metabox->callback_args.
		 *
		 * @var    string
		 * @access private
		 * @since  WPMVCBase 0.1
		 */
		private $callback;

		/**
		 * the post types to which this metabox applies
		 *
		 * The type of Write screen on which to show the edit screen section ('post', 'page', 'link', 'attachment' or 'custom_post_type' where custom_post_type is the custom post type slug)
		 *
		 * @var    array
		 * @access private
		 * @since  WPMVCBase 0.1
		 */
		private $post_types = array( 'post' );

		/**
		 * the metabox context
		 *
		 * The part of the page where the edit screen section should be shown.
		 * Valid values are 'normal', 'advanced', or 'side'.
		 *
		 * @var    string
		 * @access private
		 * @since  WPMVCBase 0.1
		 */
		private $context = 'normal';

		/**
		 * the metabox priority
		 *
		 * The priority within the context where the boxes should be shown.
		 * Valid values are 'high', 'core', 'default', or 'low'.
		 *
		 * @var    string
		 * @access private
		 * @since  WPMVCBase 0.1
		 */
		private $priority = 'default';

		/**
		 * the metabox callback arguments
		 *
		 * Arguments to pass into your callback function. The callback will receive the $post object and
		 * whatever parameters are passed through this variable.
		 *
		 * Example:
		 *
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
		 *	  echo 'Last Modified: '.$post->post_modified;		  // outputs last time the post was modified
		 *	  echo $metabox['args']['foo'];							// outputs 'this'
		 *	  echo $metabox['args']['bar'];							// outputs 'that'
		 *	  echo get_post_meta($post->ID,'my_custom_field',true); // outputs value of custom field
		 * }
		 * </code>
		 *
		 * @var    array
		 * @access private
		 * @since  WPMVCBase 0.1
		 */
		private $callback_args = array();

		/**
		 * The class constructor.
		 *
		 * Example:
		 * <code>
		 * $sample_metabox = new Base_Model_Metabox( array(
		 *      'id'            => 'sample_metabox',
		 *      'title'         => __( 'Sample Metabox', 'mytextdomain' ),
		 *      'callback'      => 'my_callback'
		 *      'post_type'     => array( 'post', 'page', 'my-custom-cpt' ),
		 *      'context'       => 'normal',
		 *      'priority'      => 'default'
		 *      'callback_args' => array( 'foo' => 'this', 'bar' => 'that' )
		 * );
		 * </code>
		 *
		 * @param  array  $args
		 * @access public
		 * @since  WPMVCBase 0.1
		 */
		public function __construct( $args = array() )
		{
			$args = wp_parse_args( $args, array(
				'id'            => 'sample-metabox',
				'title'         => __( 'Sample Metabox', 'wpmvcb' ),
				'callback'      => array( $this, 'default_callback' ),
				'post_types'     => array( 'post' ),
				'context'       => 'normal',
				'priority'      => 'default',
				'callback_args' => array(),
			) );

			$this->id            = $args['id'];
			$this->title         = $args['title'];
			$this->callback      = $args['callback'];
			$this->post_types    = $args['post_types'];
			$this->context       = $args['context'];
			$this->priority      = $args['priority'];
			$this->callback_args = $args['callback_args'];

			//check for valid values
			if ( ! in_array( $this->context, array( 'normal', 'advanced', 'side' ) ) ) {
				$this->context = 'normal';
			}

			if ( ! in_array( $this->priority, array( 'high', 'core', 'default', 'low' ) ) ) {
				$this->priority = 'default';
			}
		}

		/**
		 * remove the metabox
		 *
		 * @return void
		 * @access public
		 * @since  WPMVCBase 0.1
		 */
		public function remove()
		{
			foreach( $this->post_types as $post_type ) {
				remove_meta_box( $this->id, $post_type, $this->context );
			}
		}

		/**
		 * set the id
		 *
		 * @param  string $id
		 * @return void
		 * @access public
		 * @since  WPMVCBase 0.1
		 */
		public function set_id( $id )
		{
			$this->id = $id;
		}

		/**
		 * set the title
		 *
		 * @param  string $title
		 * @return void
		 * @access public
		 * @since  WPMVCBase 0.1
		 */
		public function set_title( $title )
		{
			$this->title = $title;
		}

		/**
		 * set the callback function
		 *
		 * @param  string $callback
		 * @return void
		 * @access public
		 * @since  WPMVCBase 0.1
		 */
		public function set_callback( $callback )
		{
			$this->callback = $callback;
		}

		/**
		 * set the post types
		 *
		 * @param  array $post_types
		 * @return void
		 * @access public
		 * @since  WPMVCBase 0.1
		 */
		public function set_post_type( array $post_types )
		{
			$this->post_types = $post_types;
		}

		/**
		 * set the context
		 *
		 * @param  string $context
		 * @return void
		 * @access public
		 * @since  WPMVCBase 0.1
		 */
		public function set_context( $context )
		{
			$this->context = $context;
		}

		/**
		 * set the priority
		 *
		 * @param  string $priority
		 * @return void
		 * @access public
		 * @since  WPMVCBase 0.1
		 */
		public function set_priority( $priority )
		{
			$this->priority = $priority;
		}

		/**
		 * set the callback_args
		 *
		 * @param  array $callback_args
		 * @return void
		 * @access public
		 * @since  WPMVCBase 0.1
		 */
		public function set_callback_args( $callback_args )
		{
			$this->callback_args = $callback_args;
		}

		/**
		 * get the metabox id
		 *
		 * @return string $id
		 * @access public
		 * @since  WPMVCBase 0.1
		 */
		public function get_id()
		{
			return $this->id;
		}

		/**
		 * get the metabox title
		 *
		 * @return string $id
		 * @access public
		 * @since  WPMVCBase 0.1
		 */
		public function get_title()
		{
			return $this->title;
		}

		/**
		 * get the metabox callback
		 *
		 * @return string $callback
		 * @access public
		 * @since  WPMVCBase 0.1
		 */
		public function get_callback()
		{
			return $this->callback;
		}

		/**
		 * get the metabox post_type
		 *
		 * @return string $post_type
		 * @access public
		 * @since  WPMVCBase 0.1
		 */
		public function get_post_types()
		{
			return $this->post_types;
		}

		/**
		 * get the metabox context
		 *
		 * @return string $context
		 * @access public
		 * @since  WPMVCBase 0.1
		 */
		public function get_context()
		{
			return $this->context;
		}

		/**
		 * get the metabox priority
		 *
		 * @return string $priority
		 * @access public
		 * @since  WPMVCBase 0.1
		 */
		public function get_priority()
		{
			return $this->priority;
		}

		/**
		 * get the metabox callback_args
		 *
		 * @param  WP_Post $post
		 * @return array   $callback_args
		 * @access public
		 * @since  WPMVCBase 0.1
		 */
		public function get_callback_args( $post )
		{
			return apply_filters( $this->id, $this->callback_args, $post );
		}

		/**
		 * The default metabox callback
		 */
		public function default_callback()
		{
			printf( 
				__( 'This is the default callback for the %s metabox. Please implement a callback function!', 'wpmvcb' ),
				$this->id
			);
		}
	}
}
