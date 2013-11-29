<?php
namespace WPMVCB\Testing;

class testConstraintScriptRegistered extends \WP_UnitTestCase
{
	private $_constraint;

	public function setUp()
	{
		$this->_constraint = new \WPMVCB\Testing\PHPUnit_Framework_Constraint_ScriptRegistered();
		
		//register our test script
		wp_register_script( 'fooscript', 'http://example.com/fooscript.js', array( 'jquery' ), true, true );
	}
	
	public function tearDown()
	{
		wp_deregister_script( 'fooscript' );
	}
	
	public function testNoScript()
	{
		$script = array();
		$this->assertFalse( $this->_constraint->matches( $script ) );
	}

	public function testWrongHandle()
	{
		$script = array( 'baz', 'http://example.com/fooscript.js', array( 'jquery' ), true, true );

		$this->assertFalse( $this->_constraint->matches( $script ) );
	}

	public function testWrongSrc()
	{
		$script = array( 'fooscript', 'baz', array( 'jquery' ), true, true );
		
		$this->assertFalse( $this->_constraint->matches( $script ) );
	}

	public function testWrongDeps()
	{
		$script = array( 'fooscript', 'http://example.com/fooscript.js', array( 'baz' ), true, true );

		$this->assertFalse( $this->_constraint->matches( $script ) );
	}

	public function testWrongVer()
	{
		$script = array( 'fooscript', 'http://example.com/fooscript.js', array( 'jquery' ), false, true );

		$this->assertFalse( $this->_constraint->matches( $script ) );
	}

	public function testWrongInFooter()
	{
		$script = array( 'fooscript', 'http://example.com/fooscript.js', array( 'jquery' ), true, false );

		$this->assertFalse( $this->_constraint->matches( $script ) );
	}
	
	public function testScriptExists()
	{
		$script = array( 'fooscript', 'http://example.com/fooscript.js', array( 'jquery' ), true, true );
		
		$this->assertTrue( $this->_constraint->matches( $script ) );
	}
}
