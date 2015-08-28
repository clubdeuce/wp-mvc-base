<?php
namespace WPMVCB\Testing;
	use \WP_UnitTest_Factory;

class WPMVCB_Tests_Factory extends WP_UnitTest_Factory
{
	public $mock;

	public function __construct()
	{
		parent::__construct();

		$this->mock = new WPMVCB_Tests_Factory_For_Mock( $this );
	}
}
