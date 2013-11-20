<?php
/**
 * The base plugin controller.
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

include_once 'base_controller.php';

if ( ! class_exists( 'Base_Controller_Plugin' ) ) {
    /**
     * The base plugin controller.
     *
     * @package WPMVCBase\Controllers
     * @abstract
     * @version 0.2
     * @since WP_Base 0.1
     */
    abstract class Base_Controller_Plugin extends Base_Controller
    {
        /**
         * The plugin model.
         *
         * @var object
         * @since 0.2
         */
        protected $plugin_model;

        /**
         * The class constructor
         *
         * Example when called from the main plugin file:
         * <code>
         * $my_plugin_controller = new Base_Controller_Plugin(
         *		'my_plugin_slug',
         *		'1.1.5',
         *		plugin_dir_path( __FILE__ ),
         *		__FILE__,
         *		plugin_dir_uri( __FILE__ ),
         *		'my_text_domain'
         * }
         * </code>
         *
         * @category Controllers
         * @package WPMVCBase
         *
         * @param object $model The plugin model.
         * @access public
         * @since 0.1
         */
        public function __construct( $model )
         {
            if ( ! is_a( $model, 'Base_Model_Plugin' ) ) {
            	trigger_error( 
            		sprintf( __( '%s expects an instance of Base_Model_Plugin', 'wpmvcb' ), __FUNCTION__ ),
            		E_USER_WARNING
            	);
            }
			
			parent::__construct();
			
			$this->plugin_model = $model;
			
			add_action( 'plugins_loaded',        array( &$this, 'load_text_domain' ) );
			add_action( 'admin_enqueue_scripts', array( &$this, 'admin_enqueue_scripts' ) );
			add_action( 'add_meta_boxes',        array( &$this, 'add_meta_boxes' ) );
			add_action( 'wp_enqueue_scripts',    array( &$this, 'wp_enqueue_scripts' ) );
			add_action( 'admin_notices',         array( &$this, 'admin_notice' ) );
         }

        /**
         * Load the plugin text domain.
         *
         * @internal
         * @access public
         * @since 0.1
         */
        public function load_text_domain()
        {
            if( is_dir( $this->path . '/languages/' ) )
                load_plugin_textdomain( $this->txtdomain, false, $this->path . '/languages/' );
        }

        /**
         * Render admin notices for this screen.
         *
         * @internal
         * @access public
         * @since 0.1
         */
        public function admin_notice()
        {
            $screen = get_current_screen();

            if( isset ( $this->admin_notices[$screen->id] ) ):
                foreach( $this->admin_notices[$screen->id] as $notice ):
                    echo $notice;
                endforeach;
            endif;
        }

        /**
         * The WP load-{$page} action callback
         *
         * @package WP Models
         * @internal
         * @access public
         * @since 0.1
         */
        public function load_admin_page()
        {
            //determine the page we are on
            $screen = get_current_screen();

            //are there help tabs for this screen?
            if ( isset( $this->help_tabs[ $screen->id ] ) ):
                foreach( $this->help_tabs[ $screen->id ] as $tab ):
                    $tab->add();
                endforeach;
            endif;

            //are there javascripts registered for this screen?
            if ( isset( $this->admin_js[ $screen->id ] ) ):
                foreach( $this->admin_js[ $screen->id ] as $script ):
                    $script->enqueue();
                    $script->localize();
                endforeach;
            endif;

            //are there styles registered for this screen?
            if ( isset( $this->admin_css[ $screen->id ] ) ):
                Helper_Functions::enqueue_styles( $this->admin_css[ $screen->id ] );
            endif;
		}

        /**
         * Enqueue scripts and styles for admin pages
         *
         * @param string $hook The WP page hook.
         * @uses globalHelper_Functions::enqueue_styles() to enqueue the styles.
         * @uses Helper_Functions::enqueue_scripts() to enqueue the scripts.
         * @uses Base_Model_CPT::get_admin_css() to retrieve the CPT admin css.
         * @uses Base_Model_CPT::get_admin_scripts() to retrieve the CPT admin scripts.
         * @internal
         * @access public
         * @since 0.1
         * @todo modify this function to enqueue scripts based on wp_screen object
         */
        public function admin_enqueue_scripts( $hook )
        {
            global $post;
            $screen = get_current_screen();

            //register the scripts
            if( isset( $this->admin_scripts ) ):
                foreach( $this->admin_scripts as $script ):
                    $script->register();
                    $script->enqueue();
                endforeach;
            endif;

            if ( ( $hook == 'post.php' || $hook == 'edit.php' || $hook == 'post-new.php' ) ) {
                if ( isset( $this->cpts ) ) {
                    foreach ($this->cpts as $cpt) {
                        if ( $cpt->get_slug() == $screen->post_type ) {
                            //enqueue the admin css
                            $css = $cpt->get_admin_css( $this->css_uri );
                            if ( is_array( $css ) )
                                Helper_Functions::enqueue_styles( $css );

                            if ($hook == 'post.php' || $hook == 'post-new.php') {
                                //enqueue the scripts on single post edit pages
                                $scripts = $cpt->get_admin_scripts( $post, $this->txtdomain, $this->js_uri );
                                if ( is_array( $scripts ) ) {
                                    foreach( $scripts as $script ):
                                        $script->enqueue();
                                        $script->localize();
                                    endforeach;
                                }
                            }	//$hook == 'post.php' || $hook == 'post-new.php'
                            break;
                        }	//$cpt->get_slug() == $screen->post_type
                    }	//foreach( $this->cpts as $cpt )
                }	//isset( $this->cpts )
            }	//$hook == 'post.php' || $hook == 'edit.php' || $hook == 'post-new.php'
        }

        /**
         * Enqueue scripts and styles for frontend pages
         *
         * @uses Helper_Functions::enqueue_styles()
         * @uses Helper_Functions::enqueue_scripts()
         * @uses Base_Model_CPT::get_css()
         * @uses Base_Model_CPT::get_scripts()
         * @internal
         * @access public
         * @since 0.1
         */
        public function wp_enqueue_scripts()
        {
            global $post;

            //add any global css
            if( is_array( $this->css ) ):
                Helper_Functions::enqueue_styles( $this->css, $this->css_uri );
            endif;

            //add the global javascripts
            if( isset( $this->js) && is_array( $this->js ) )
                Helper_Functions::enqueue_scripts( $this->js );

            //get our cpt scripts and css
            if ( isset ( $this->cpts ) ):
                foreach( $this->cpts as $cpt ):
                    if( $cpt->get_slug() == $post->post_type ):
                        //enqueue the cpt scripts
                        $scripts = $cpt->get_scripts( $post, $this->txtdomain, $this->js_uri );
                        if ( is_array( $scripts ) )
                            Helper_Functions::enqueue_scripts( $scripts );

                        //enqueue the cpt css
                        $css = $cpt->get_css( $this->css_uri );
                        if ( is_array( $css ) )
                            Helper_Functions::enqueue_styles( $css );
                        break;
                    endif;
                endforeach;
            endif;
        }

        /**
         * WP the_post action callback.
         *
         * @package WP Models
         * @param object $post The WP post object.
         * @return object $post The modified post object.
         * @internal
         * @access public
         * @since 0.1
         */
        /*
public function callback_the_post( $post )
        {
            switch ($post->post_type) {
                case 'post':
                    if ( method_exists( $this, 'the_post' ) ):
                        $post = $this->the_post( $post );
                    endif;
                    break;
                case 'page':
                    if ( method_exists( $this, 'the_page' ) ):
                        $post = $this->the_page( $post );
                    endif;
                    break;
                default:
                    if( isset( $this->cpts ) ):
                        foreach($this->cpts as $cpt):
                            if ( $cpt->get_slug() == $post->post_type && method_exists( $cpt, 'the_post' ) ):
                                $post = $cpt->the_post( $post );
                                break;
                            endif;
                        endforeach;
                    endif;
                    break;
            }

            return $post;
        }
*/

        /**
         * WP delete_post action hook callback
         *
         * @param string $post_id
         * @internal
         * @access public
         * @since 0.1
         */
        public function callback_delete_post( $post_id )
        {
            $post_type = get_post_type( $post_id );

            // We need to check if the current user is authorised to do this action.
            if ( ! current_user_can( 'delete_post', $post_id ) )
                    return;

            //If we made it this far, we can delete the post
            //decide the post type, and then call the appropriate delete function
            switch ($post_type) {
                case 'post':
                    if ( method_exists( $this, 'delete_data_post' ) )
                        return $this->delete_data_post( $post_id );
                    break;
                case 'page':
                    if ( method_exists( $this, 'delete_data_page' ) )
                        return $this->delete_data_page( $post_id );
                    break;
                default:
                    if( isset( $this->cpts ) ):
                        foreach($this->cpts as $cpt):
                            if ( $cpt->get_slug() ==  $post_type && method_exists( $cpt, 'delete' ) ):
                                return $cpt->delete( $_POST );
                                break;
                            endif;
                        endforeach;
                    endif;
                    break;
            }
        }

        /**
         * Add the cpt.
         *
         * Register the cpt, add the cpt scripts and styles, add the meta boxes and help screens.
         *
         * @since 0.2
         */
        public function add_cpt( $cpt )
        {
            if ( ! is_a( $cpt, 'Base_Model_CPT'  ) ) {
            	trigger_error( sprintf( __( '%s expects an object of type Base_Model_CPT', 'wpmvcb' ), __FUNCTION__ ), E_USER_WARNING );
            }
            
			$this->cpts[ $cpt->get_slug() ] = $cpt;
			add_action( 'init', array( &$cpt, 'register' ) );
			add_action( 'add_meta_boxes', array( &$this, 'add_meta_boxes' ) );
			
			//register the post updated messages
			add_action( 'post_updated_messages', array( &$this, 'post_updated_messages' ), 5 );
			
			if ( method_exists( $cpt, 'the_post' ) ) {
				add_action( 'the_post', array( &$this, 'callback_the_post' ) );
			}
			
			if ( method_exists( $cpt, 'save_post' ) ) {
				add_action( 'save_post', array( &$this, 'callback_save_post' ) );
			}
			
			if ( method_exists( $cpt, 'delete_post' ) ) {
				add_action( 'delete_post', array( &$this, 'callback_delete_post' ) );
			}
			
			if ( is_array( $cpt->get_help_tabs( $this->app_views_path, $this->txtdomain ) ) ) {
				$this->help_tabs[ $cpt->get_slug() ] = $cpt->get_help_tabs( $this->app_views_path, $this->txtdomain );
			}
			
			if ( is_array( $cpt->get_shortcodes() ) ) {
				add_action( 'init', array( &$this, 'wp_init' ) );
			}
        }

        public function add_settings_model( $model )
        {
            if ( ! is_a( $model, 'Base_Model_Settings' ) ) {
                trigger_error( sprintf( __( '%s parameter expects a Base_Model_Settings object', 'wpmvcb' ), __FUNCTION__ ), E_USER_WARNING );
            }
            
            $this->_settings_model = $model;
        }
    }	// class Base_Controller_Plugin
}	// ! class_exists( 'Base_Controller_Plugin' )
