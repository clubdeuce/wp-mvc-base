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
class WPMVCB_Post_View_Base {

	/**
	 * @var WPMVCB_Cpt_Model_Base
	 */
	protected $item;

	public function __construct( $item ) {

		$this->item = $item;

	}

	public function the_template( $template, $args = array() ) {

		$item = $this->item;

		extract( $args );

		if( file_exists( $template ) ) {
			printf( '<!-- Template: %1$s -->', str_replace( WP_CONTENT_DIR, 'CONTENT_DIR', $template ) );
			require $template;
		}

	}

	public function the_image( $size = 'full', $args = array() ) {

		if ( is_callable( array( $this->item, 'get_image' ) ) ) {
			echo $this->item->get_image( $size, $args );
		}

	}

}
