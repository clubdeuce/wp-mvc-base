<?php
/**
 * The base controller.
 *
 * @author Daryl Lozupone <daryl@actionhook.com>
 * @since WPMVCBase 0.1
 */

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

if ( ! class_exists( 'Base_Controller' ) ):
	/**
	 * The base controller.
	 *
	 * @package WPMVCBase\Controllers
	 * @abstract
	 * @version 0.1
	 * @since WP_Base 0.3
	 */
	class Base_Controller
	{
		public function __construct()
		{
			add_action( 'init', array( &$this, 'add_shortcodes' ) );
			add_action( 'add_meta_boxes', array( &$this, 'add_meta_boxes' ) );
			add_action( 'admin_enqueue_scripts', array( &$this, 'admin_enqueue_scripts' ) );
		}

		public function add_shortcodes( $shortcodes )
		{
			if ( ! is_array( $shortcodes ) ) {
				trigger_error(
					sprintf( __( 'Function %s expects an array', 'wpmvcb' ), __FUNCTION__ ),
					E_USER_WARNING
				);
			}
			
			foreach ( $shortcodes as $key => $shortcode ) {
				add_shortcode( $key, $shortcode );
			}
		}

		/**
		 * The WP add_meta_boxes action callback
		 *
		 * @internal
		 * @access public
		 * @since 0.1
		 */
		public function add_meta_boxes()
		{
			global $post;

			$metaboxes = $this->model->get_metaboxes( $post->ID, $this->txtdomain );

			if ( is_array( $metaboxes ) ) {
				foreach ( $metaboxes as $metabox ) {
					if ( is_null( $metabox->get_callback() ) ) {
						$metabox->set_callback( array( &$this, 'render_metabox' ) );
					}
					$metabox->add();
				}
			}
		}
		
		/**
		 * Enqueue scripts for the admin dashboard.
		 *
		 * @return void
		 * @since WPMVCBase 0.3
		 */
		public function admin_enqueue_scripts()
		{
			if ( isset( $this->admin_scripts ) ) {
				foreach ( $this->admin_scripts as $script ) {
					$script->enqueue();
				}
			}
		}
		
		/**
		 * Render a metabox.
		 *
		 * This function serves as the callback for a metabox.
		 *
		 * @param object $post The WP post object.
		 * @param object $metabox The WP_Metabox object to be rendered.
		 * @param string $txtdomain The plugin text domain.
		 * @param string $nonce_action The plugin nonce action.
		 * @param string $nonce_name The plugin nonce name.
		 * @internal
		 * @access public
		 * @todo move the filter into the add function
		 * @since 0.1
		 */
		public function render_metabox( $post, $metabox )
		{
			//get elements required for this particular view
			$metabox = apply_filters( 'filter_metabox_callback_args', $metabox, $post );

			//add the uri
			$metabox['args']['uri'] = $this->uri;

			if ( isset( $this->nonce_action ) && isset( $this->nonce_name ) ):
				//generate a nonce
				$nonce = wp_nonce_field( $this->nonce_action, $this->nonce_name, true, false );
			endif;

			if ( isset( $this->txtdomain ) ):
				$txtdomain = $this->txtdomain;
			else :
				$txtdomain = '';
			endif;

			//Is a view file specified for this metabox?
			if ( isset( $metabox['args']['view'] ) ) :
				if ( file_exists( $metabox['args']['view'] ) ) :
					//require the appropriate view for this metabox
					include_once( $metabox['args']['view'] );
				else :
					trigger_error(
						sprintf(
							__( 'The view file %s for metabox id %s does not exist', $this->txtdomain ),
							$metabox['args']['view'],
							$metabox['id']
						),
						E_USER_WARNING
					);
				endif;
			else :
				trigger_error(
					sprintf(
						__( 'No view specified in the callback arguments for metabox id %s', $this->txtdomain ),
						$metabox['id']
					),
					E_USER_WARNING
				);
			endif;
		}
		
		/**
		 * WP save_post action authenticator.
		 *
		 * @param string $post_id The WP post id.
		 * @param string $post_type The post type.
		 * @param object $post_data The POSTed data.
		 * @internal
		 * @access public
		 * @since 0.1
		 */
		public function authenticate_post( $post_id, $post_type, $post_data, $nonce_name, $nonce_action )
		{

			// verify if this is an auto save routine.
			// If it is our form has not been submitted, so we dont want to do anything
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
				return;
			}

			// We need to check if the current user is authorised to do this action.
			switch ( $post_type ) {
				case 'page':
					if ( ! current_user_can( 'edit_page', $post_id ) ) {
						return;
					}
				default:
					if ( ! current_user_can( 'edit_post', $post_id ) ) {
						return;
					}
			}

			// Third we need to check if the user intended to change this value.
			if ( ! isset( $post_data[ $nonce_name ] ) || ! wp_verify_nonce( $post_data[ $nonce_name ], $nonce_action ) ) {
				return;
			}

			return true;
		}
	}
endif;
