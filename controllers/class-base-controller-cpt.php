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

if ( ! class_exists( 'Base_Controller_CPT' ) && class_exists( 'Base_Controller' ) ) :
	/**
	 * The base custom post type controller.
	 *
	 * @package WPMVCBase\Controllers
	 * @version 0.1
	 * @since WPMVCBase 0.3
	 */
	class Base_Controller_CPT extends Base_Controller
	{
		/**
		 * The attached custom post type models.
		 *
		 * @var array
		 * @access protected
		 * @since 0.1
		 */
		protected $_cpt_models;

		public function __construct()
		{
			parent::__construct();
			add_action( 'init',                  array( &$this, 'register' ) );
			add_filter( 'post_updated_messages', array( &$this, 'post_updated_messages' ) );
			//add_action( 'admin_enqueue_scripts', array( &$this, 'admin_enqueue_scripts' ) );
			//add_action( 'wp_enqueue_scripts',    array( &$this, 'wp_enqueue_scripts' ) );
		}

		/**
		 * Add a cpt model to this controller.
		 *
		 * @param object $model The Base_Model_CPT for this controller.
		 * @access public
		 * @since 0.3
		 */
		public function add_model( $model, $the_post = null, $save_post = null, $delete_post = null )
		{
			if ( ! is_a( $model, 'Base_Model_CPT' ) ) {
				trigger_error( sprintf( __( '%s expects an object of type Base_Model_CPT', 'wpmvcb' ), __FUNCTION__ ), E_USER_WARNING );
			}
			
			$this->_cpt_models[ $model->get_slug() ] = $model;

			if ( isset( $the_post ) ) {
				add_action( 'the_post', $the_post );
			}

			if ( isset( $save_post ) ) {
				add_action( 'save_post', $save_post );
			}

			if ( isset( $delete_post ) ) {
				add_action( 'delete_post', $delete_post );
			}

			add_action( 'post_updated_messages', array( &$model, 'get_post_updated_messages' ) );
		}

		/**
		 * Register this post type.
		 *
		 * @return array An array for each post type containing the registered post type object on success, WP_Error object on failure
		 * @access public
		 * @since 0.3
		 * @link http://codex.wordpress.org/Function_Reference/register_post_type
		 */
		public function register()
		{
			if ( isset( $this->_cpt_models ) ) {
				foreach ( $this->_cpt_models as $cpt ) {
					$return[ $cpt->get_slug() ] = register_post_type( $cpt->get_slug(), $cpt->get_args() );
				}
			}
			return $return;
		}

		/**
		 * Filter to ensure the CPT labels are displayed when user updates the CPT
		 *
		 * @param array $messages The existing messages array.
		 * @return array $messages The updated messages array.
		 * @internal
		 * @access public
		 * @since 0.1
		 * @link http://codex.wordpress.org/Plugin_API/Filter_Reference
		 */
		public function post_updated_messages( $messages )
		{
			global $post;
			if ( isset( $this->_cpt_models ) ) {
				foreach ( $this->_cpt_models as $cpt ) {
					if ( method_exists( $cpt, 'get_post_updated_messages' ) ) {
						$messages[ $cpt->get_slug() ] = $cpt->get_post_updated_messages( $post, $this->txtdomain );
					}
				}
			}

			return $messages;
		}
		
		/**
		 * Add the metaboxes necessary for the custom post types.
		 *
		 * @since WPMVCBase 0.3
		 */
		public function add_meta_boxes()
		{
			if ( isset( $this->_cpt_models ) && is_array( $this->_cpt_models ) ) {
				foreach ( $this->_cpt_models as $cpt ) {
					if ( $metaboxes = $cpt->get_metaboxes() ) {
						foreach ( $metaboxes as $metabox ) {
							$metabox->add();
						}
					}
				}
			}
		}
	}
endif;
