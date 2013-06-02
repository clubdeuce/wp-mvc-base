<?php
/**
 * The default settings section view.
 *
 * @package WP Models\Views
 * @author Daryl Lozupone <daryl@actionhook.com>
 * @version 0.1
 * @since WP Base 0.1
 */
?>
<?php 
if ( isset( $setting_section['content'] ) && $setting_section['content'] != '' )
	echo $setting_section['content'];
?>