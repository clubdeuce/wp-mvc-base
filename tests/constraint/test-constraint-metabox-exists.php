<?php
namespace WPMVCB\Testing;

class testConstraintMetaboxExists extends \WP_UnitTestCase
{
	private $_constraint;

	public function setUp()
	{
		$this->_constraint = new \WPMVCB\Testing\PHPUnit_Framework_Constraint_MetaboxExists();
	}

	public function testNoMetabox()
	{
		$args = array();
		$this->assertFalse( $this->_constraint->matches( $args ) );
	}

	public function testWrongId()
	{
		$args = array( 'foocpt', 'Foo Meta', 'time', 'post', 'normal', 'default', array( 'foo' => 'bar' ) );
		add_meta_box( 'bar', 'Foo Meta', 'time', 'post', 'normal', 'default', array( 'foo' => 'bar' ) );

		$this->assertFalse( $this->_constraint->matches( $args ) );
		remove_meta_box( 'bar', 'post', 'normal' );
	}

	public function testWrongTitle()
	{
		$args = array( 'foocpt', 'Foo Meta', 'time', 'post', 'normal', 'default', array( 'foo' => 'bar' ) );
		add_meta_box( 'foocpt', 'Bar Meta', 'time', 'post', 'normal', 'default', array( 'foo' => 'bar' ) );

		$this->assertFalse( $this->_constraint->matches( $args ) );
		remove_meta_box( 'foocpt', 'post', 'normal' );
	}

	public function testWrongCallback()
	{
		$args = array( 'foocpt', 'Foo Meta', 'time', 'post', 'normal', 'default', array( 'foo' => 'bar' ) );
		add_meta_box( 'foocpt', 'Foo Meta', 'phpinfo', 'post', 'normal', 'default', array( 'foo' => 'bar' ) );

		$this->assertFalse( $this->_constraint->matches( $args ) );
		remove_meta_box( 'foocpt', 'post', 'normal' );
	}

	public function testWrongPostType()
	{
		$args = array( 'foocpt', 'Foo Meta', 'time', 'page', 'normal', 'default', array( 'foo' => 'bar' ) );
		add_meta_box( 'foocpt', 'Foo Meta', 'time', 'post', 'normal', 'default', array( 'foo' => 'bar' ) );

		$this->assertFalse( $this->_constraint->matches( $args ) );
		remove_meta_box( 'foocpt', 'post', 'normal' );
	}

	public function testWrongContext()
	{
		$args = array( 'foocpt', 'Foo Meta', 'time', 'post', 'side', 'default', array( 'foo' => 'bar' ) );
		add_meta_box( 'foocpt', 'Foo Meta', 'time', 'post', 'normal', 'default', array( 'foo' => 'bar' ) );

		$this->assertFalse( $this->_constraint->matches( $args ) );
		remove_meta_box( 'foocpt', 'post', 'normal' );
	}

	public function testWrongPriority()
	{
		$args = array( 'foocpt', 'Foo Meta', 'time', 'post', 'normal', 'high', array( 'foo' => 'bar' ) );
		add_meta_box( 'foocpt', 'Foo Meta', 'time', 'post', 'normal', 'default', array( 'foo' => 'bar' ) );

		$this->assertFalse( $this->_constraint->matches( $args ) );
		remove_meta_box( 'foocpt', 'post', 'normal' );
	}

	public function testWrongCallbackArgs()
	{
		$args = array( 'foocpt', 'Foo Meta', 'time', 'post', 'normal', 'default', array( 'foo' => 'bar' ) );
		add_meta_box( 'foocpt', 'Foo Meta', 'time', 'post', 'normal', 'default', array( 'bar' => 'baz' ) );

		$this->assertFalse( $this->_constraint->matches( $args ) );
		remove_meta_box( 'foocpt', 'post', 'normal' );
	}

	public function testMetaboxExists()
	{
		$args = array( 'foocpt', 'Foo Meta', 'time', 'post', 'normal', 'default', array( 'foo' => 'bar' ) );
		add_meta_box( 'foocpt', 'Foo Meta', 'time', 'post', 'normal', 'default', array( 'foo' => 'bar' ) );

		$this->assertTrue( $this->_constraint->matches( $args ) );
		remove_meta_box( 'foocpt', 'post', 'normal' );
	}
}
