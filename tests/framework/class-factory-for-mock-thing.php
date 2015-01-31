<?php
namespace WPMVCB\Testing;
    use \WP_UnitTest_Factory_For_Thing;

/**
 * Class WPMVCB_Tests_Factory_For_Mock
 *
 * @package  DBP\Tests
 * @abstract
 */
abstract class WPMVCB_Tests_Factory_For_Mock_Thing
{
    /**
     * @var WPMVCB_Tests_Factory
     */
    protected $factory;

    public function __construct( $factory = null )
    {
        $this->factory = $factory;
    }

    /**
     * Create and return a mock object
     *
     * @param    array $args
     * @return   mixed
     * @abstract
     */
    public abstract function create( array $args = array() );
}
