<?php
namespace WPMVCB\Testing\UnitTests;
	use \WPMVCB\Testing\WPMVCB_Test_Case;
    use \WPMVCB_Metabox;

require_once( WPMVCB_SRC_DIR . '/controllers/class-metabox-base.php' );

/**
 * The tests for WPMVCB_Metabox_Base
 *
 * @package             WPMVCB\Testing\Unit_Tests
 * @group               Metabox
 * @coversDefaultClass  WPMVCB_Metabox
 * @since               WPMVCBase 0.4
 * @internal
 */
class Test_WPMVCB_Metabox extends WPMVCB_Test_Case
{
	/**
	 * @var WPMVCB_Metabox
	 */
	private $sut;

	/**
	 * The mock model object
	 */
	private $model;

	/**
	 * The mock view object
	 */
	private $view;

	public function setUp()
	{
		parent::setUp();

		$this->model = $this->factory->mock->metabox->model->create( array( 'post_types' => array( 'page' ) ) );
		$this->view  = new \stdClass();
		$this->sut   = new WPMVCB_Metabox( array(
			'model'  => $this->model,
			'view'   => $this->view,
		) );
	}

	/**
	 * @covers ::__construct
	 */
	public function testConstructorSetsModel()
	{
		$this->assertEquals( $this->model, $this->getReflectionPropertyValue( $this->sut, 'model' ) );
	}

	/**
	 * @covers ::__construct
	 */
	public function testConstructorSetsView()
	{
		$this->assertEquals( $this->view, $this->getReflectionPropertyValue( $this->sut, 'view' ) );
	}

	/**
	 * @covers ::__construct
	 */
	public function testConstructorAddsActions()
	{
		$this->assertGreaterThan( 0, has_action( 'add_meta_boxes-page', array( $this->sut, 'add' ) ) );
	}

	/**
	 * @covers ::add
	 */
	public function testMethodAdd()
	{
		$this->markTestIncomplete();
		
		$post = $this->factory->post->create_and_get();

		$this->sut->add( $post );
		
		$this->assertMetaboxExists(
			array(
				$this->model->get_id(),
				$this->model->get_title(),
				$this->model->get_callback(),
				'page',
				$this->model->get_priority(),
				$this->model->get_context(),
				$this->model->get_callback_args( $post )
			)
		);
	}
}
