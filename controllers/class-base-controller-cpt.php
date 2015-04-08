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
require_once 'class-base-controller.php';

if ( ! class_exists( 'Base_Controller_CPT' ) && class_exists( 'Base_Controller' ) ) {
	/**
	 * The base custom post type controller.
	 *
	 * @package WPMVCBase\Controllers
	 * @version 0.2
	 * @since   WPMVCBase 0.2
	 */
	class Base_Controller_CPT extends Base_Controller
	{	
		/**
		 * The class constructor.
		 *
		 * @access public
		 * @since  WPMVCBase 0.1
		 */
		public function __construct( array $args = array() )
        {
			parent::__construct( $args );

			add_action( 'init',                  array( $this, 'register' ) );
			add_filter( 'post_updated_messages', array( $this, 'post_updated_messages' ) );
		}

		/**
		 * Register this post type.
		 *
		 * @return array An array containing the registered post type objects on success, WP_Error object on failure
		 * @access public
		 * @since  WPMVCBase 0.2
		 * @link   http://codex.wordpress.org/Function_Reference/register_post_type
		 */
		public function register()
		{
			return register_post_type( $this->model->get_slug(), $this->model->get_args() );
		}

		/**
		 * Filter to ensure the CPT labels are displayed when user updates the CPT
		 *
		 * @param    array $messages The existing messages array.
		 * @return   array $messages The updated messages array.
		 * @internal
		 * @access   public
		 * @since    WPMVCBase 0.1
		 * @link     http://codex.wordpress.org/Plugin_API/Filter_Reference
		 */
		public function post_updated_messages( $messages )
		{
			global $post;

			$messages[ $this->model->get_slug() ] = array(
				0 => null, // Unused. Messages start at index 1.
				1 => sprintf(
					__( '%1$s updated. <a href="%3$s">View %2$s</a>', 'wpmvcb' ),
					$this->model->get_singular(),
					strtolower( $this->model->get_singular() ),
					esc_url( get_permalink( $post->ID ) )
				),
				2 => __( 'Custom field updated.', 'wpmvcb' ),
				3 => __( 'Custom field deleted.', 'wpmvcb' ),
				4 => sprintf( __( '%s updated.', 'wpmvcb' ), $this->model->get_singular() ),
				/* translators: %2$s: date and time of the revision */
				5 => isset( $_GET['revision'] ) ? sprintf( __( '%1$s restored to revision from %s', 'wpmvcb' ), $this->model->get_singular(), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
				6 => sprintf( __( '%1$s published. <a href="%2$s">View %1$s</a>', 'wpmvcb' ), $this->model->get_singular(), esc_url( get_permalink( $post->ID ) ) ),
				7 => sprintf( __( '%s saved.', 'wpmvcb' ), $this->model->get_singular() ),
				8 => sprintf(
					__( '%1$s submitted. <a target="_blank" href="%3$s">Preview %2$s</a>', 'wpmvcb' ),
					$this->model->get_singular(),
					strtolower( $this->model->get_singular() ),
					esc_url( add_query_arg( 'preview', 'true', get_permalink( $post->ID ) ) )
				),
				9 => sprintf(
					__( '%3$s scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview %4$s</a>', 'wpmvcb' ),
					// translators: Publish box date format, see http://php.net/date
					date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ),
					esc_url( get_permalink( $post->ID ) ),
					$this->model->get_singular(),
					strtolower( $this->model->get_singular() )
				),
				10 => sprintf(
					__( '%1$s draft updated. <a target="_blank" href="%3$s">Preview %2$s</a>', 'wpmvcb' ),
					$this->model->get_singular(),
					strtolower( $this->model->get_singular() ),
					esc_url( add_query_arg( 'preview', 'true', get_permalink( $post->ID ) ) )
				)
			);

			return $messages;
		}
	}
}
