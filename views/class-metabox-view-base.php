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
	 * Render the metabox
	 *
	 * @param WP_Post $post
	 * @param array   $metabox
	 */
	abstract public function render( $post, $metabox );
}
