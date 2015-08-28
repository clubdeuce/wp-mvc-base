<?php
namespace WPMVCB\Testing;
	use \WP_UnitTest_Factory_For_Thing;
	use \Mockery;

class WPMVCB_Tests_Factory_For_Mock_Metabox_Model extends WPMVCB_Tests_Factory_For_Mock_Thing
{
	public function __construct( $factory = null )
	{
		parent::__construct( $factory );
	}

	/**
	 * Create the mock metabox model
	 *
	 * @param  array        $args
	 * @return Mockery\Mock
	 */
	public function create( array $args = array() )
	{
		$args = wp_parse_args( $args, array(
			'id'            => 'mock-metabox-model',
			'title'         => 'Mock Metabox Title',
			'post_types'    => array( 'post' ),
			'callback'      => array( $this, 'callback' ),
			'priority'      => 'default',
			'context'       => 'normal',
			'callback_args' => array( 'foo' => 'bar' ),
		) );

		$mock = Mockery::mock( 'WPMVCB_Mock_Metabox_Model' );
		$mock->shouldReceive( 'get_id' )->andReturn( $args['id'] );
		$mock->shouldReceive( 'get_title')->andReturn( $args['title'] );
		$mock->shouldReceive( 'get_post_types' )->andReturn( $args['post_types'] );
		$mock->shouldReceive( 'get_callback' )->andReturn( $args['callback'] );
		$mock->shouldReceive( 'get_priority' )->andReturn( $args['priority'] );
		$mock->shouldReceive( 'get_context' )->andReturn( $args['context'] );
		$mock->shouldReceive( 'get_callback_args' )->andReturn( $args['callback_args'] );

		return $mock;
	}
}
