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
 * WPMVCB_Metabox
 */
class WPMVCB_Metabox extends Base_Controller {

	public function __construct( $args = array() )
	{
		$args = wp_parse_args( $args, array(
			'view' => new WPMVCB_Metabox_Default_View(),
		) );

		parent::__construct( $args );

		foreach ( $this->model->get_post_types() as $post_type ) {
			add_action( "add_meta_boxes_{$post_type}", array( $this, 'add' ) );
		}
	}

	/**
	 * Add the metabox
	 *
	 * @param  WP_Post $post
	 * @return void
	 * @access public
	 * @since  WPMVCBase 0.1
	 */
	public function add( $post ) {

		add_meta_box(
			$this->model->get_id(),
			$this->model->get_title(),
			array( $this->view, 'render' ),
			$post->post_type,
			$this->model->get_context(),
			$this->model->get_priority(),
			$this->model->get_callback_args( $post )
		);

	}

}
