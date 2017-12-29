<?php
namespace WPMVCB;

/**
 * Class Taxonomy_Base
 *
 * @since WPMVCBase 0.4
 */
class Taxonomy_Base {

	/**
	 * The taxonomy slug
	 */
	const TAXONOMY = null;

	/**
	 * The term class
	 */
	const INSTANCE_CLASS = null;
	
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
	 *
	 */
	public static function get_term() {

	}

	/**
	 * Register this taxonomy
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

Taxonomy_Base::on_load();
