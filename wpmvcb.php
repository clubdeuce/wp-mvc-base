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

class WPMVCB
{
    /**
     * A list of all classes contained in the framework.
     *
     * @var array
     */
    private static $autoload_classes;

    /**
     * Initialize the class
     *
     * @return void
     */
    public static function init() {
        self::$autoload_classes = array(
            'Base_Controller'             => 'controllers/class-base-controller.php',
            'Base_Controller_CPT'         => 'controllers/class-base-controller-cpt.php',
            'Base_Controller_Plugin'      => 'controllers/class-base-controller-plugin.php',
            'Base_Controller_Settings'    => 'controllers/class-base-controller-settings.php',
            'WPMVCB_Metabox'              => 'controllers/class-metabox-base.php',
            'Base_Model'                  => 'models/class-base-model.php',
            'Base_Model-Admin-Notice'     => 'models/class-base-model-admin-notice.php',
            'Base_Model_CPT'              => 'models/class-base-model-cpt.php',
            'Base_Model_Help_Tab'         => 'models/class-base-model-help-tab.php',
            'Base_Model_JS_Object'        => 'models/class-base-model-js-object.php',
            'Base_Model_Menu_Page'        => 'models/class-base-model-menu-page.php',
            'Base_Model_Metabox'          => 'models/class-base-model-metabox.php',
            'Base_Model_Plugin'           => 'models/class-base-model-plugin.php',
            'Base_Model_Settings'         => 'models/class-base-model-settings.php',
            'Base_Model_Taxonomy'         => 'models/class-base-model-taxonomy.php',
            'WPMVCB_View_Base'            => 'views/class-view-base.php',
            'WPMVCB_Metabox_View_Base'    => 'views/class-metabox-view-base.php',
            'WPMVCB_Metabox_Default_View' => 'views/class-metabox-view-default.php',
            'Helper_Functions'            => 'helpers/class-base-helpers.php',
        );

        spl_autoload_register( array( __CLASS__, 'autoloader' ) );
    }

    /**
     * Autoload classes
     *
     * $param string $class The class to be loaded
     * @return void
     */
    public static function autoloader( $class ) {
        if ( isset( self::$autoload_classes[ $$class ] ) ) {
            if ( file_exists( self::$autoload_classes[ $class ] ) ) {
                require_once self::$autoload_classes[ $class ];
            }
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

WPMVCB::init();
