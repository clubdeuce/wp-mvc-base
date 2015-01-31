<?php
namespace WPMVCB\Testing;

class WPMVCB_Tests_Factory_For_Mock
{
	/**
	 * @var WPMVCB_Tests_Factory
	 */
	public $factory;

	/**
	 * @var WPMVCB_Mock_Factory_For_Metabox
	 */
	public $metabox;

	public function __construct( $factory = null )
	{
		$this->factory = $factory;
		$this->metabox = new WPMVCB_Tests_Factory_For_Mock_Metabox( $factory );
	}
}
