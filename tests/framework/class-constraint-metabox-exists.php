<?php
namespace WPMVCB\Testing;
/**
 * Custom PHPUnit constraint class.
 *
 * This class provides the constraint MetaboxExists, which verifies the metabox has been
 * registered with WordPress and that all associatied properties ( e.g. id, title, etc )
 * are properly set.
 *
 * @package WPMVCBase\Testing
 * @since 0.3
 * @author Daryl Lozupone <dlozupone@renegadetechconsulting.com>
 *
 */

class MetaboxExists extends \PHPUnit_Framework_Constraint
{
	public function matches($args)
	{
		global $wp_meta_boxes;

		$metabox_id    = $args[0];
		$title         = $args[1];
		$callback      = $args[2];
		$post_type     = $args[3];
		$context       = $args[4];
		$priority      = $args[5];
		$callback_args = $args[6];

		if ( ! isset( $wp_meta_boxes ) ) {
			return false;
		}

		if ( ! array_key_exists( $post_type, $wp_meta_boxes ) ) {
			return false;
		}

		if ( ! array_key_exists( $context, $wp_meta_boxes[ $post_type ] ) ) {
			return false;
		}

		if ( ! array_key_exists( $priority, $wp_meta_boxes[ $post_type ][ $context ] ) ) {
			return false;
		}

		if ( ! array_key_exists( $metabox_id, $wp_meta_boxes[ $post_type ][ $context ][ $priority ] ) ) {
			return false;
		}

		if ( ! in_array( $metabox_id, $wp_meta_boxes[ $post_type ][ $context ][ $priority ][ $metabox_id ] ) ) {
			return false;
		}

		if ( ! in_array( $title, $wp_meta_boxes[ $post_type ][ $context ][ $priority ][ $metabox_id ] ) ) {
			return false;
		}

		if ( ! in_array( $callback, $wp_meta_boxes[ $post_type ][ $context ][ $priority ][ $metabox_id ] ) ) {
			return false;
		}

		if ( ! in_array( $callback_args, $wp_meta_boxes[ $post_type ][ $context ][ $priority ][ $metabox_id ] ) ) {
			return false;
		}

		return true;
	}

	public function toString()
	{
		return 'metabox exists';
	}
}
