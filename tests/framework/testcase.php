<?php
namespace WPMVCB\Testing
{
	class WPMVCB_Test_Case extends \WP_UnitTestCase
	{
		public function setUp()
		{
			parent::setUp(); 
			$this->factory = new WPMVCB_Tests_Factory();
		}
		
		public function getReflectionPropertyValue( $class, $property )
		{
			$reflection = new \ReflectionProperty( $class, $property );
			$reflection->setAccessible( true );
			return $reflection->getValue( $class );
		}
		
		public function setReflectionPropertyValue( $class, $property, $value )
		{
			$reflection = new \ReflectionProperty( $class, $property );
			$reflection->setAccessible( true );
			return $reflection->setValue( $class, $value );
		}
		
		public function reflectionMethodInvoke( $class, $method )
		{
			$reflection = new \ReflectionMethod( $class, $method );
			$reflection->setAccessible( true );
			$reflection->invoke( $class );
		}
		
		public function reflectionMethodInvokeArgs( $class, $method, $args )
		{
			$reflection = new \ReflectionMethod( $class, $method );
			$reflection->setAccessible( true );
			$reflection->invoke( $class, $args );
		}

		/**
		 * Assert a metabox is registered with WordPress and associated properties are correctly set.
		 *
		 * @param array $args Contains: metabox id, title, callback, post type, context, priority, callback args
		 * @param string $message The error message displayed on failure.
		 * @return bool
		 * @since 0.3
		 * @link http://codex.wordpress.org/Function_Reference/add_meta_box
		 */
		public static function assertMetaboxExists( $args, $message = '' )
		{
			self::assertThat( $args, self::metaboxExists(), $message );
		}
		
		/** 
		 * Returns a PHPUnit_Framework_Constraint_MetaboxExists matcher object.
	     *
	     * @return object PHPUnit_Framework_Constraint_MetaboxExists
	     * @since  0.3
	     */
		public static function metaboxExists()
		{
			return new \WPMVCB\Testing\PHPUnit_Framework_Constraint_MetaboxExists();
		}
		
		/**
		 * Assert a javascript is registered with WordPress and associated properties are correctly set.
		 *
		 * @param array $sacript Contains: handle, src, deps, ver, in_footer
		 * @param string $message The error message displayed on failure.
		 * @return bool
		 * @since 0.3
		 * @link http://codex.wordpress.org/Function_Reference/wp_register_script
		 */
		public static function assertScriptRegistered( $script, $message = '' )
		{
			self::assertThat( $script, self::scriptRegistered(), $message );
		}
		
		/** 
		 * Returns a PHPUnit_Framework_Constraint_ScriptRegistered matcher object.
	     *
	     * @return object PHPUnit_Framework_Constraint_ScriptRegistered
	     * @since  0.3
	     */
		public static function scriptRegistered()
		{
			return new \WPMVCB\Testing\PHPUnit_Framework_Constraint_ScriptRegistered();
		}
	}
}
