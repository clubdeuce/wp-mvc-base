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

class WPMVCB  {

    /**
     * A list of files that must be loaded at plugin initialization
     *
     * @var array
     */
    private $mustload_files = array();

    /**
     * A list of all classes contained in the framework.
     *
     * @var array
     */
    private $autoload_classes = array();

    /**
     * A collection of post type slugs and arguments used to register the post type as key/value pairs
     *
     * @var array
     */
    private $post_type_args = array();

    /**
     * Initialize the class
     *
     * @return void
     */
    public function __construct() {
        $this->autoload_classes = array(
            'Base_Controller'             => __DIR__ . '/controllers/class-base-controller.php',
            'Base_Controller_CPT'         => __DIR__ . '/controllers/class-base-controller-cpt.php',
            'Base_Controller_Plugin'      => __DIR__ . '/controllers/class-base-controller-plugin.php',
            'Base_Controller_Settings'    => __DIR__ . '/controllers/class-base-controller-settings.php',
            'WPMVCB_Metabox'              => __DIR__ . '/controllers/class-metabox-base.php',
            'Base_Model'                  => __DIR__ . '/models/class-base-model.php',
            'Base_Model-Admin-Notice'     => __DIR__ . '/models/class-base-model-admin-notice.php',
            'Base_Model_CPT'              => __DIR__ . '/models/class-base-model-cpt.php',
            'Base_Model_Help_Tab'         => __DIR__ . '/models/class-base-model-help-tab.php',
            'Base_Model_JS_Object'        => __DIR__ . '/models/class-base-model-js-object.php',
            'Base_Model_Menu_Page'        => __DIR__ . '/models/class-base-model-menu-page.php',
            'Base_Model_Metabox'          => __DIR__ . '/models/class-base-model-metabox.php',
            'Base_Model_Plugin'           => __DIR__ . '/models/class-base-model-plugin.php',
            'Base_Model_Settings'         => __DIR__ . '/models/class-base-model-settings.php',
            'Base_Model_Taxonomy'         => __DIR__ . '/models/class-base-model-taxonomy.php',
            'WPMVCB_View_Base'            => __DIR__ . '/views/class-view-base.php',
            'WPMVCB_Metabox_View_Base'    => __DIR__ . '/views/class-metabox-view-base.php',
            'WPMVCB_Metabox_Default_View' => __DIR__ . '/views/class-metabox-view-default.php',
            'Helper_Functions'            => __DIR__ . '/helpers/class-base-helpers.php',
        );

        spl_autoload_register( array( $this, 'autoloader' ) );

        add_action( 'init', array( $this, 'init' ) );
        add_action( 'muplugins_loaded', array( $this, 'load_mustloads' ) );
    }

    /**
     * Add additional class name/absloute path pairs to the list of classes able to be autoloaded.
     *
     * @param array $classes
     */
    public function register_autoload_classes( array $classes ) {
        $this->autoload_classes = array_merge( $this->autoload_classes, $classes );
    }

    /**
     * Autoload classes
     *
     * $param string $class The class to be loaded
     * @return void
     */
    public function autoloader( $class ) {
        if ( isset( $this->autoload_classes[ $class ] ) ) {
            if ( file_exists( $this->autoload_classes[ $class ] ) ) {
                require_once $this->autoload_classes[ $class ];
            }
        }
    }

    /**
     * Add files that must be loaded at plugin initialization
     *
     * @param array $files
     */
    public function register_mustload_files( array $files ) {

        $this->mustload_files = array_merge( $files, $this->mustload_files );

    }

    /**
     * Load the files in the $mustload property
     */
    public function load_mustloads() {

        foreach( $this->mustload_files as $file ) {
            if( file_exists( $file ) ) {
                require_once $file;
            }
        }

    }

    public function register_post_type_args( $slug, $args = array() ) {

        $this->post_type_args[ $slug ] = $args;

    }

    public function init() {

        $this->register_post_types();

    }

    private function register_post_types() {

        foreach( $this->post_type_args as $slug => $args ) {
            register_post_type( $slug, $args );
        }
        
    }

    /**
     * Get the main library directory
     *
     * @return string
     */
    public function get_source_dir() {

        return __DIR__;

    }
}
