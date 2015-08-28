<?php
namespace WPMVCB\Testing\Unit_Tests;
	use WPMVCB\Testing\WPMVCB_Test_Case;
	use WPMVCB_Metabox_Default_View;

/**
 * Test_Metabox_View_Default
 *
 * @package            WPMVCB\Testing\Unit_Tests
 * @group              Metabox
 * @coversDefaultClass WPMVCB_Metabox_Default_View
 * @since              WPMVCBase 0.4
 * @internal
 */
class Test_Metabox_View_Default extends WPMVCB_Test_Case
{
	/**
	 * @var WPMVCB_Metabox_Default_View
	 */
	protected $sut;
	
	public function setUp()
	{
		parent::setUp();

		$this->sut = new WPMVCB_Metabox_Default_View();
	}

	/**
	 * @covers ::render
	 */
	public function testRender()
	{
		$post    = $this->factory->post->create_and_get();
		$metabox = new \stdClass(); 

		ob_start();
		$this->sut->render( $post, $metabox );
		$result = ob_get_clean();

		$this->assertInternalType( 'string', $result );
		$this->assertNotEmpty( $result );
	}
}
