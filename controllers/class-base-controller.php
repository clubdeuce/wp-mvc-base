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

if ( ! class_exists( 'Base_Controller' ) ) {
	/**
	 * The base controller.
	 *
	 * @package  WPMVCBase\Controllers
	 * @abstract
	 * @version  0.2
	 * @since WPMVCBase 0.2
	 */
	abstract class Base_Controller
	{
		protected $args;

        protected $model;
        
        protected $view;
		
		/**
		 * The class constructor
		 *
		 * @access public
		 * @since  WPMVCBase 0.1
		 */
		public function __construct( array $args = array() )
		{
            $args = wp_parse_args( $args, array(
                'model' => null,
                'view'  => null,
            ) );

            $this->args  = $args;
            $this->model = $args['model'];
            $this->view  = $args['view'];

			add_action( 'wp_enqueue_scripts',    array( $this, 'wp_enqueue_scripts' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
			add_action( 'add_meta_boxes',        array( $this, 'add_meta_boxes' ) );
		}
		
		/**
		 * Add shortcodes to WP.
		 *
		 * @param  array $shortcodes An array of key/value pairs containing the shortcode as key and the callback function as value.
		 * @return WP_Error|null
		 * @since  WPMVCBase 0.1
		 */
		public function add_shortcodes( array $shortcodes )
		{	
			foreach ( $shortcodes as $key => $shortcode ) {
				add_shortcode( $key, $shortcode );
			}
		}
		
		/**
		 * Enqueue scripts.
		 *
		 * @param  array $scripts Array containing Base_Model_JS objects
		 * @return WP_Error|null  WP_Error object on failure.
		 * @since  WPMVCBase 0.3
		 */
		public function enqueue_scripts( array $scripts )
		{	
			foreach ( $scripts as $key => $script ) {
				if( is_a( $script, 'Base_Model_JS_Object' ) ) {
					wp_enqueue_script(
						$script->get_handle(),
						$script->get_src(),
						$script->get_deps(),
						$script->get_ver(),
						$script->get_in_footer()
					);
				}
				
				if( ! is_a( $script, 'Base_Model_JS_Object' ) ) {
					if( ! isset( $wp_error ) ) {
						$wp_error = new WP_Error();
					}
					
					$wp_error->add(
						'invalid object type',
						sprintf( __( '%s is not a Base_Model_JS_Object', 'wpmvcbase' ), $key ),
						$script
					);
				}
			}
			
			//return the error object for invalid script types
			if( isset( $wp_error ) ) {
				return $wp_error;
			}
		}
		
		/**
		 * Render a metabox.
		 *
		 * This function serves as the callback for a metabox.
		 *
		 * @param    object $post The WP post object.
		 * @param    object $metabox The WP_Metabox object to be rendered.
		 * @internal
		 * @access   public
		 * @since    WPMVCBase 0.1
		 * @todo     move the filter into the add function
		 */
		public function render_metabox( WP_Post $post, $metabox )
		{
			//Is a view file specified for this metabox?
			if ( isset( $metabox['args']['view'] ) ) {
				if ( file_exists( $metabox['args']['view'] ) ) {
				
					//include view for this metabox
					include $metabox['args']['view'];
					return;
				}
				
				if ( file_exists( $this->app_path . 'views/' . $metabox['args']['view'] ) ) {
					include $this->app_path . 'views/' . $metabox['args']['view'];
					return;
				}
				
				if ( ! file_exists( $metabox['args']['view'] ) ) {
					printf(
						__( 'The view file %s for metabox id %s does not exist', 'wpmvcb' ),
						$metabox['args']['view'],
						$metabox['id']
					);
					return;
				}
			}
			
			if ( ! isset( $metabox['args']['view'] ) ) {
				printf(
					__( 'No view specified in the callback arguments for metabox id %s', 'wpmvcb' ),
					$metabox['id']
				);
				return;
			}
		}
		
		/**
		 * Render a help tab.
		 *
		 * @param object Base_Model_Help_Tab
		 * access public
		 * @since 1.0
		 */
		public function render_help_tab( Base_Model_Help_Tab $tab )
		{
			$screen = get_current_screen();
			
			$screen->add_help_tab( 
				array( 
					'id'      => $tab->get_id(),
					'title'   => $tab->get_title(),
					'content' => $tab->get_content()
				)
			);
		}

		public function __call( $method, $args ) {

			$message = sprintf( __( 'Method %s not found in class %s or its model or view', 'wpmvcb' ), $method, get_called_class() );
			$value   = new WP_Error( 400, $message );

			foreach( array( $this->view, $this->model ) as $object ) {
				if ( is_object( $object ) && method_exists( $object, $method ) ) {
					$value = call_user_func_array( array( $object, $method ), $args );
				}
			}

			if ( is_wp_error( $value ) ) {
				trigger_error( $message );
			}

			return $value;

		}

		public function __get( $property ) {

			$message = sprintf( 'Property %s not found in %s or its model or view', $property, get_called_class() );
			$value   = new WP_Error( 400, $message );

			foreach( array( $this->view, $this->model ) as $object ) {
				if ( is_object( $object ) && property_exists( $object, $property ) ) {
					$value = $object->{$property};
				}
			}

			if ( is_wp_error( $value ) ) {
				trigger_error( $message );
			}

			return $value;
		}
	}
}
