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
 * WPMVCB_Metabox_View_Base
 *
 * The metabox view base
 */
abstract class WPMVCB_Metabox_View_Base
{
	/**
	 * The arguments passed into this class
	 *
	 * @var array
	 */
	protected $args;

	/**
	 * The class constructor
	 *
	 * @param array $args
	 */
	public function __construct( $args = array() )
	{
		$this->args = $args;
	}

	/**
	 * Render a metabox.
	 *
	 * This function serves as the callback for a metabox.
	 *
	 * @param    WP_Post $post    The WP post object.
	 * @param    object  $metabox The WP_Metabox object to be rendered.
	 * @internal
	 * @access   public
	 * @since    WPMVCBase 0.4
	 */
	public function render( $post, $metabox ) {

		//Is a view file specified for this metabox?
		if ( isset( $metabox['args']['view'] ) ) {
			if ( file_exists( $metabox['args']['view'] ) ) {

				//include view for this metabox
				include $metabox['args']['view'];
				return;
			}

			if ( ! file_exists( $metabox['args']['view'] ) ) {
				printf(
					__( 'The view file %s for metabox id %s does not exist', 'wpmvcb' ),
					$metabox['args']['view'],
					$metabox['id']
				);
				return;
			}
		}

		if ( ! isset( $metabox['args']['view'] ) ) {
			printf(
				__( 'No view specified in the callback arguments for metabox id %s', 'wpmvcb' ),
				$metabox['id']
			);
			return;
		}

	}

}
