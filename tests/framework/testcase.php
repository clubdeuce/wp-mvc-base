<?php
namespace WPMVCB\Testing
{
	class WPMVCB_Test_Case extends \WP_UnitTestCase
	{
		public function __construct()
		{
			parent::setUp(); 
			$this->factory = new \WP_UnitTest_Factory;
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
		 * The assertion assertMetaboxExists.
		 *
		 * @param array $args Contains: metabox id, title, callback, post type, context, priority, callback args
		 * @return bool
		 * @since 0.3
		 */
		public static function assertMetaboxExists( $args, $message = '' )
		{
			self::assertThat( $args, self::metaboxExists(), $message );
		}

		public static function metaboxExists()
		{
			return new \WPMVCB\Testing\MetaboxExists();
		}
	}
}
