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

/**
 * Class Base_Controller_Taxnomy
 *
 * @since WPMVCBase 0.4
 */
class Base_Controller_Taxonomy extends Base_Controller {

	/**
	 * The taxonomy slug
	 *
	 * @var   string
	 */
	public static $taxonomy = null;
	
	/**
	 * The post type slugs to which this taxonomy is assigned
	 *
	 * @var array
	 */
	protected static $object_types = array();

	/**
	 * The taxonomy slug and arguments stored as key/value pairs
	 */
	protected static $taxonomy_args = array();

	/**
	 * Register a taxonomy
	 *
	 * @param string $slug
	 * @param array  $object_types
	 * @param array  $args
	 */
	public static function register_taxonomy_args( $slug, $object_types, $args ) {

		self::$taxonomy_args[ $slug ] = array(
			'object_types' => $object_types,
			'args'         => $args,
		);

	}

	/**
	 * The WP init action callback
	 */
	public static function init() {

		foreach( self::$taxonomy_args as $slug => $taxonomy ) {
			register_taxonomy( $slug, $taxonomy['object_types'], $taxonomy['args'] );
		} 

	}

	/**
	 * Initialize the labels.
	 * 
	 * @access public
	 * @param  string $singular
	 * @param  string $plural
	 * @return array            An array containing key/value pairs for the taxonomy labels.
	 */
	public static function init_labels( $singular, $plural ) {

		return array(
			'name'              => $plural,
			'singular_name'     => $singular,
			'search_items'      => sprintf( __( 'Search %s',   'wpmvcb' ), $plural ),
			'all_items'         => sprintf( __( 'All %s',      'wpmvcb' ), $plural ),
			'parent_item'       => sprintf( __( 'Parent %s',   'wpmvcb' ), $singular ),
			'parent_item_colon' => sprintf( __( 'Parent %s:',  'wpmvcb' ), $singular ),
			'edit_item'         => sprintf( __( 'Edit %s',     'wpmvcb' ), $singular ),
			'update_item'       => sprintf( __( 'Update %s',   'wpmvcb' ), $singular ),
			'add_new_item'      => sprintf( __( 'Add New %s',  'wpmvcb' ), $singular ),
			'new_item_name'     => sprintf( __( 'New %s Name', 'wpmvcb' ), $singular ),
			'menu_name'         => $plural,
		);

	}

	/**
	 * Initialize the controller
	 */
	public static function on_load() {

		add_action( 'init', array( __CLASS__, 'init' ) );

	}

}

Base_Controller_Taxonomy::on_load();
