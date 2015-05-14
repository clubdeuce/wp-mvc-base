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

if ( ! class_exists( 'WPMVCB_Cpt_Model_Base' ) && class_exists( 'WPMVCB_Model_Base' ) ) {

	/**
	 * The base CPT object model.
	 *
	 * @package WPMVCBase\Models
	 * @version 0.2
	 * @since   WPMVCBase 0.1
	 */
	abstract class WPMVCB_Cpt_Model_Base extends WPMVCB_Model_Base {
		/**
		 * @var WP_Post $post
		 */
		protected $post;

		/**
		 * @var WP_Post|int $post
		 * @var array $args
		 */
		public function __construct( $post, $args = array() ) {

			if ( is_int( $post ) ) {
				$post = get_post( $post );
			}

			if ( is_a( $post, 'WP_Post' ) ) {
				$this->post = $post;
			}

			parent::__construct( $args );

		}
	}

}
