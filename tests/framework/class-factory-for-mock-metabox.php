<?php
namespace WPMVCB\Testing;

class WPMVCB_Tests_Factory_For_Mock_Metabox extends WPMVCB_Tests_Factory_For_Mock_Thing
{
	public $model;
	public $view;

	public function __construct( $factory = null )
	{
		$this->factory = $factory;
		$this->model   = new WPMVCB_Tests_Factory_For_Mock_Metabox_Model( $factory );
		//$this->view    = new WPMVCB_Tests_Factory_For_Mock_Metabox_View( $factory );
	}

	public function create( array $args = array() )
	{
		$model = new WPMVCB_Tests_Factory_For_Mock_Metabox_Model( $this->factory );
		$args = wp_parse_args( $args, array(
			'model' => $model->create(),
			'view'  => null,
		) );

		$mock = Mockery::mock( 'WPMVCB_Mock_Metabox' );
		$mock->model = $args['model'];
		$mock->view  = $args['view'];

		return $mock;
	}
}
