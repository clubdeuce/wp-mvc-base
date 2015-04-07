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

if ( ! class_exists( 'Base_Model' ) ) :
	/**
	 * The base model.
	 *
	 * This class serves as the base for other models provided by the framework. It contains the properties and
	 * and methods required by other models.
	 *
	 * @package  WPMVCBase\Models
	 * @internal
	 * @since    WPMVCBase 0.1
	 */
	abstract class Base_Model
	{
		/**
		 * The args passed in to the model
		 *
		 * @var    array
		 * @access protected
		 * @since  WPMCVBase 0.4
		 */
		protected $args;

		/**
		 * The css files required by this model
		 *
		 * An array containing css used by the model.
		 *
		 * @var    array
		 * @access protected
		 * @since  WPMVCBase 0.1
		 */
		protected $css;

		/**
		 * The plugin admin css files.
		 *
		 * An array containing css used by the model on admin pages
		 *
		 * @var    array
		 * @access protected
		 * @since  WPMVCBase 0.1
		 */
		protected $admin_css;

		/**
		 * The model javascript files
		 *
		 * An array containing a collection of javascript objects used by the model on the frontend.
		 *
		 * @var    array
		 * @access protected
		 * @since  WPMVCBase 0.1
		 * @see    WPMVCBase\Models\Base Model JS Object
		 */
		protected $scripts;

		/**
		 * The model admin javascript files
		 *
		 * An array containing a collection of javascript objects used by the model on admin pages.
		 *
		 * @var    array
		 * @access protected
		 * @since  WPMVCBase 0.1
		 */
		protected $admin_scripts;

		/**
		 * Metaboxes required by this model.
		 *
		 * @var    array Contains an array of WP_Base_Metabox objects
		 * @access protected
		 * @since  WPMVCBase 0.1
		 * @see    WPMVCBase\Models\Base_Model_Metabox
		 */
		protected $metaboxes;

		/**
		 * The model's help tabs.
		 *
		 * This is a collection of Base_Model_Help_Tab objects.
		 *
		 * @var    array
		 * @access protected
		 * @since  WPMVCBase 0.2
		 * @see    Base_Model_Help_Tabs
		 */
		protected $help_tabs;

		/**
		 * The model's shortcodes.
		 *
		 * @var    array
		 * @access protected
		 * @since  WPMVCBase 0.2
		 */
		protected $shortcodes;
		
		/**
		 * The model's admin notices.
		 *
		 * This is a collection of Base_Model_Admin_Notice objects.
		 *
		 * @var    array
		 * @access protected
		 * @since  WPMVCBase 0.2
		 * @see    Base_Model_Admin_Notice
		 */
		protected $admin_notices;
		
		/**
		 * The class constructor.
		 *
		 * @param  array $args
		 * @access public
		 * @since  WPMVCBase 0.1
		 */
		public function __construct( $args )
		{
			$args = wp_parse_args( $args, array(
                'css'           => null,
                'admin_css'     => null,
                'scripts'       => null,
                'admin_scripts' => null,
                'metaboxes'     => null,
                'help_tabs'     => null,
                'shortcodes'    => null,
                'admin_notices' => null,
            ) );

			$this->args          = $args;
            $this->css           = $args['css'];
            $this->admin_css     = $args['admin_css'];
            $this->scripts       = $args['scripts'];
            $this->admin_scripts = $args['admin_scripts'];
            $this->metaboxes     = $args['metaboxes'];
            $this->help_tabs     = $args['help_tabs'];
            $this->admin_notices = $args['admin_notices'];
		}

		/**
		 * Get the frontend CSS.
		 *
		 * @return array|bool $css if set, FALSE if not.
		 * @access public
		 * @since  WPMVCBase 0.1
		 */
		public function get_css()
		{
			if ( isset( $this->css ) ) {
				return $this->css;
			}
			
			return false;
		}

		/**
		 * Get the admin CSS.
		 *
		 * @return array|bool $admin_css if set, FALSE if not.
		 * @access public
		 * @since  WPMVCBase 0.1
		 */
		public function get_admin_css()
		{
			if ( isset( $this->admin_css ) ) {
				return $this->admin_css;
			}
			
			return false;
		}

		/**
		 * Get the front end javascripts.
		 *
		 * @return array $scripts if set, FALSE if not.
		 * @access public
		 * @since  WPMVCBase 0.1
		 */
		public function get_scripts()
		{
			if ( isset( $this->scripts ) ) {
				return $this->scripts;
			}
			
			return false;
		}

		/**
		 * Get the admin javascripts.
		 *
		 * @return array|bool $admin_scripts if set, FALSE if not.
		 * @access public
		 * @since  WPMVCBase 0.1
		 */
		public function get_admin_scripts()
		{
			if ( isset( $this->admin_scripts ) ) {
				return $this->admin_scripts;
			}
			
			return false;
		}

		/**
		 * Get the model's metaboxes.
		 *
		 * @return array|bool $metaboxes if set, FALSE if not.
		 * @access public
		 * @since  WPMVCBase 0.1
		 * @see    WP_Metabox
		 */
		public function get_metaboxes()
		{	
			if ( isset( $this->metaboxes ) ) {
				return $this->metaboxes;
			}
				
			return false;
		}

		/**
		 * Get the cpt help screen tabs.
		 *
		 * @return array|bool $help_tabs if set, FALSE if not.
		 * @access public
		 * @since  WPMVCBase 0.1
		 */
		public function get_help_tabs()
		{	
			if ( isset( $this->help_tabs ) ) {
				return $this->help_tabs;
			}
			
			return false;
		}
		
		/**
		 * Get the model's shortcodes.
		 *
		 * @return array|bool $shortcodes if set, FALSE if not.
		 * @access public
		 * @since  WPMVCBase 0.1
		 */
		public function get_shortcodes()
		{
			if ( isset( $this->shortcodes ) ) {
				return $this->shortcodes;
			}
			
			return false;
		}

		/**
		 * Add a help tab object.
		 *
		 * @param  string $handle The help tab handle.
		 * @param  object $help_tab The Base_Model_Help_Tab object.
		 * @return bool|object TRUE on success, WP_Error on failure.
		 * @access public
		 * @since  WPMVCBase 0.2
		 * @see    Base_Model_Help_Tab
		 */
		public function add_help_tab( $handle, $help_tab )
		{
			if ( ! is_array( $this->help_tabs ) ) {
				$this->help_tabs = array();
			}
			
			if ( $help_tab instanceOf Base_Model_Help_Tab ) {
				$this->help_tabs = array_merge( $this->help_tabs, array( $handle => $help_tab ) );
				return true;
			}
			
			//A valid help tab object is not included.
			return new WP_Error(
				'invalid object type',
				sprintf( __( '%s::%s expects a Base_Model_Help_Tab object as the second parameter', 'wpmvcb' ), __CLASS__, __FUNCTION__ ),
				$help_tab
			);
		}
		
		/**
		 * Add a shortcode object.
		 *
		 * @param  string $shortcode The shortcode name.
		 * @param  string $callback The shortcode callback handler.
		 * @return void
		 * @access public
		 * @since  WPMVCBase 0.1
		 */
		public function add_shortcode( $shortcode, $callback )
		{
			if ( ! isset( $this->shortcodes ) ) {
				$this->shortcodes = array();
			}
			
			if ( is_callable( $callback ) ) {
				$this->shortcodes = array_merge( $this->shortcodes, array( $shortcode => $callback ) );
				return true;
			}
			
			return new WP_Error(
				'not callable',
				sprintf( __( '%s::%s expects a valid callback.', 'wpmvcb' ), __CLASS__, __FUNCTION__ ),
				$callback
			);
		}
		
		/**
		 * WP save_post action authenticator.
		 *
		 * This method verifies an autosave is not in progress, the current user can edit the post being submitted,
		 * and that a valid nonce is present.
		 *
		 * @param    string $post_id      The WP post id.
		 * @param    string $post_type    The post type.
		 * @param    object $post_data    The POSTed data.
		 * @param    string $nonce_name   The name of the nonce.
		 * @param    string $nonce_action The nonce action.
		 * @internal
		 * @access   public
		 * @since    WPMVCBase 0.1
		 */
		public function authenticate_post( $post_id, $post_type, $post_data, $nonce_name, $nonce_action )
		{

			// verify if this is an auto save routine.
			// If it is our form has not been submitted, so we don't want to do anything
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
				return;
			}

			// We need to check if the current user is authorised to do this action.
			if ( 'page' == $post_type ) {
				if ( ! current_user_can( 'edit_page', $post_id ) ) {
					return;
				}
			}
			
			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return;
			}

			// Third we need to check if the user intended to change this value.
			if ( ! isset( $post_data[ $nonce_name ] ) || ! wp_verify_nonce( $post_data[ $nonce_name ], $nonce_action ) ) {
				return;
			}

			return true;
		}
		
		/**
		 * Get the admin notices attached to this model.
		 *
		 * @return array|bool
		 * @access public
		 * @since  WPMVCBase 0.2
		 */
		public function get_admin_notices()
		{
			if ( isset( $this->admin_notices ) ) {
				return $this->admin_notices;
			}
			
			return false;
		}

	}
endif;
