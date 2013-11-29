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

if ( ! class_exists( 'Base_Controller_CPT' ) ):
    /**
     * The base custom post type controller.
     *
     * @package WPMVCBase\Controllers
     * @version 0.1
     * @since WP_Base 0.3
     */
    class Base_Controller_CPT
    {
        /**
         * The CPT model
         *
         * @var object
         * @access protected
         * @since 0.1
         */
        protected $cpt_model;

        public function __construct( $cpt_model )
        {
            if( ! is_a( $cpt_model, 'Base_Model_CPT' ) ) {
            	trigger_error( sprintf( __( '%s expects an object of type Base_Model_CPT', 'wpmvcb' ), __FUNCTION__ ), E_USER_WARNING );
            }
            
	        $this->cpt_model = $cpt_model;
	        add_action( 'init', array( &$this, 'register' ) );
	        add_action( 'post_updated_messages', array( &$this, 'post_updated_messages' ) );
	        add_action( 'admin_enqueue_scripts', array( &$this, 'admin_enqueue_scripts' ) );
        }

        /**
         * Add a cpt model to this controller.
         *
         * @param object $model The Base_Model_CPT for this controller.
         * @access public
         * @since 0.3
         */
        public function add_model( $model, $the_post = null, $save_post = null , $delete_post = null)
        {
            if ( $model instanceOf Base_Model_CPT ):
                $this->cpt_model = $model;

                if ( isset( $the_post ) ):
                    add_action( 'the_post', $the_post );
                endif;

                if ( isset( $save_post ) ):
                    add_action( 'save_post', $save_post );
                endif;

                if ( isset( $delete_post ) ):
                    add_action( 'delete_post', $delete_post );
                endif;

                add_action( 'post_updated_messages', array( &$model, 'get_post_updated_messages' ) );
            else:
                trigger_error(
                    sprintf( __( '%s expects an object of type Base_Model_CPT', 'wpmvcb' ), __FUNCTION__ ),
                    E_USER_WARNING
                );
            endif;
        }

        /**
         * Register this post type.
         *
         * @return object The registered post type object on success, WP_Error object on failure
         * @access public
         * @since 0.3
         */
        public function register()
        {
            return register_post_type( $this->cpt_model->get_slug(), $this->cpt_model->get_args() );
        }

        /**
         * Filter to ensure the CPT label is displayed when user updates the CPT
         *
         * @param array $messages The existing messages array.
         * @return array $messages The updated messages array.
         * @internal
         * @access public
         * @since 0.1
         */
        public function post_updated_messages( $messages )
        {
            global $post;

            if ( method_exists( $this->cpt_model, 'get_post_updated_messages' ) ):
                $messages[ $this->cpt_model->get_slug() ] = $this->cpt_model->get_post_updated_messages( $post, $this->txtdomain );
            endif;

            return $messages;
        }
    }
endif;
