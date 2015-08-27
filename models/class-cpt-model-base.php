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

		/**
		 * @return bool
		 */
		public function has_post() {

			$has_post = false;

			if( isset( $this->post ) && is_a( $this->post, 'WP_Post' ) ) {
				$has_post = true;
			}

			return $has_post;

		}

		/**
		 * @return WP_Post
		 */
		public function get_post() {

			return $this->post;

		}

		/**
		 * @return bool
		 */
		public function has_image() {

			$value = false;

			if ( $this->has_post() ) {
				$value = has_post_thumbnail( $this->post->ID );
			}

			return $value;
		}

		/**
		 * @param $size
		 * @param array $attr
		 * @return mixed|null|void
		 */
		public function get_image( $size, $attr = array() ) {

			$value = null;

			if( $this->has_image() ) {
				$value =  get_the_post_thumbnail( $this->post->ID, $size, $args );
			}

			return $value;
		}

		/**
		 * @return int
		 */
		public function get_image_id() {

			$value = 0;

			if ( $this->has_post() ) {
				if ( $this->has_image() ) {
					$value  = get_post_thumbnail_id( $this->post->ID );
				}
			}

			return $value;

		}

		/**
		 * @return int
		 */
		public function get_id() {

			$id = 0;

			if ( isset( $this->post ) && is_a( $this->post, 'WP_Post' ) ) {
				$id = $this->post->ID;
			}

			return $id;

		}

		/**
		 * @return string
		 */
		public function get_title() {

			$title = '';

			if ( isset( $this->post ) && is_a( $this->post, 'WP_Post' ) ) {
				$title = get_the_title( $this->post->ID );
			}

			return $title;

		}

		public function get_permalink() {

			$permalink = '';

			if ( isset( $this->post ) && is_a( $this->post, 'WP_Post' ) ) {
				$permalink = get_permalink( $this->post->ID );
			}

			return $permalink;

		}

	}

}
