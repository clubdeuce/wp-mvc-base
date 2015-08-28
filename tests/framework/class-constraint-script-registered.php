<?php
namespace WPMVCB\Testing;
/**
 * Custom PHPUnit constraint class.
 *
 * This class provides the constraint ScriptRegistered, which verifies the script has been
 * registered with WordPress and that all associatied properties ( e.g. handle, src, etc )
 * are properly set.
 *
 * @package WPMVCBase\Testing
 * @since 0.3
 * @author Daryl Lozupone <dlozupone@renegadetechconsulting.com>
 *
 */

class PHPUnit_Framework_Constraint_ScriptRegistered extends \PHPUnit_Framework_Constraint
{
	/**
     * Evaluates the constraint for parameter $args. Returns TRUE if the
     * constraint is met, FALSE otherwise.
     *
     * @param array $script An array containing the elements to evaluate. This array MUST take the following form:
     * <code>
     *     array( handle, src, deps, ver, in_footer )
     * </code>
     * @return bool
     */
	public function matches($script)
	{
		global $wp_scripts;

		if ( ! isset( $wp_scripts ) || empty( $script ) ) {
			return false;
		}
		
		if ( ! true === wp_script_is( $script[0], 'registered' ) ) {
			return false;
		}
		
		if ( $script[0] != $wp_scripts->registered[ $script[0] ]->handle ) {
			return false;
		}
		
		if ( $script[1] != $wp_scripts->registered[ $script[0] ]->src ) {
			return false;
		}
		
		if ( $script[2] != $wp_scripts->registered[ $script[0] ]->deps ) {
			return false;
		}
		
		if ( $script[3] != $wp_scripts->registered[ $script[0] ]->ver ) {
			return false;
		}
		
		
		if ( $script[4] != $wp_scripts->registered[ $script[0] ]->extra['group'] ) {
			return false;
		}

		return true;
	}
	
	/**
     * Returns a string representation of the constraint.
     *
     * @return string
     */
	public function toString()
	{
		return 'script registered';
	}
}
