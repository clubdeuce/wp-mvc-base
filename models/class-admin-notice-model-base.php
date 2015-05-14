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

if ( ! class_exists( 'WPMVCB_Admin_Notice_Model_Base' ) ) {
	/**
	 * The base admin notice object model.
	 *
	 * @package WPMVCBase\Models
	 * @version 0.2
	 * @since   WPMVCBase 0.2
	 */
	class WPMVCB_Admin_Notice_Model_Base
	{
		/**
		 * The notice type ( updated or error ).
		 * 
		 * @var    string
		 * @access private
		 * @since  WPMVCBase 0.2
		 */
		private $type;
		
		/**
		 * The admin notice message.
		 * 
		 * @var    string
		 * @access private
		 * @since  WPMVCBase 0.2
		 */
		private $message;
		
		/**
		 * The screens on which to display this admin notice.
		 * 
		 * @var    array
		 * @access private
		 * @since  WPMVCBase 0.2
		 */
		private $screens;
		
		/**
		 * The class constructor.
		 *
		 * @param  string $type The notice type. Either 'updated' or 'error'.
		 * @param  string $message The notice message.
		 * @param  array  $screens The WP screen id's on which to display this notice. If not set, notice appears on all screens.
		 * @access public
		 * @since  WPMVCBase 0.2
		 */
		public function __construct( $type, $message, array $screens = null )
		{
			$this->type    = $type;
			$this->message = $message;
			$this->screens = array( 'all' );
			
			if ( isset( $screens ) ) {
				$this->screens  = $screens;
			}
		}
		
		/**
		 * Get the notice type.
		 *
		 * @return string $type Either 'updated' or 'error'.
		 * @access public
		 * @since  WPMVCBase 0.2
		 */
		public function get_type()
		{
			return $this->type;
		}
		
		/**
		 * Get the admin notice message.
		 *
		 * @return string $message
		 * @access public
		 * @since  WPMVCBase 0.2
		 */
		public function get_message()
		{
			return $this->message;
		}
		
		/**
		 * Get the screen(s) on which to apply this notice.
		 *
		 * @return array|string $screens An array of the screens or the string 'all' for all screens.
		 * @access public
		 * @since  WPMVCBase 0.2
		 */
		public function get_screens()
		{
			return $this->screens;
		}
	}
}
