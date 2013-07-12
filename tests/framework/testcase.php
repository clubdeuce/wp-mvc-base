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
			$reflection = new \ReflectionClass( $class );
			$property_reflection = $reflection->getProperty( $property );
			$property_reflection->setAccessible( true );
			return $property_reflection->getValue( $class );
		}
		
		public function setReflectionPropertyValue( $class, $property, $value )
		{
			$reflection = new \ReflectionClass( $class );
			$property_reflection = $reflection->getProperty( $property );
			$property_reflection->setAccessible( true );
			return $property_reflection->setValue( $class, $value );
		}
	}
}
?>