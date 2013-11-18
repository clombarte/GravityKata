<?php

namespace Gravity;

/**
 * Test for IceBlockSimulator class.
 *
 * @author Carlos Lombarte <lombartec@gmail.com>
 */
class IceBlockSimulatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * The instance of the class to test.
     *
     * @var IceBlockSimulator
     */
    private $obj;

    /**
     * Executed before every test case.
     */
    public function setUp()
    {
        $this->obj = new IceBlockSimulator();
    }

    /**
     * Tests that simulateData method throws an EmptySimulationDataException when the simulation data is empty.
     */
    public function testThatSimulateThrowsExceptionWhenSimulationDataIsEmpty()
    {
        $this->setExpectedException( 'Gravity\EmptySimulationDataException' );
        $this->obj->simulateData( array(), array() );
    }

    /**
     * Data provider for testSimulateData method.
     *
     * @return array
     */
    public function simulateDataProvider()
    {
        return array(
            'One block falls' => array(
                'data_to_simulate' => array(
                    array( '|X|', '', '', '', '' ),
                    array( '', '', '', '', '' ),
                    array( '', '', '', '', '' ),
                ),
                'block_to_move' => array(),
                'expected' => array(
                    array( '', '', '', '', '' ),
                    array( '', '', '', '', '' ),
                    array( '|X|', '', '', '', '' ),
                ),
                'message' => 'The block must be at the bottom'
            ),
            'One block pushed from left' => array(
                'data_to_simulate' => array(
                    array( '', '', '', '', '' ),
                    array( '', '', '', '', '' ),
                    array( '|X|', '', '', '', '' ),
                ),
                'block_to_move' => array(
                    'x' => 0,
                    'y' => 2
                ),
                'expected' => array(
                    array( '', '', '', '', '' ),
                    array( '', '', '', '', '' ),
                    array( '', '|X|', '', '', '' ),
                ),
                'message' => 'The block must move to the right'
            ),
            'One block falls having one at bottom' => array(
                'data_to_simulate' => array(
                    array( '|X|', '', '', '', '' ),
                    array( '', '', '', '', '' ),
                    array( '|X|', '', '', '', '' ),
                ),
                'block_to_move' => array(),
                'expected' => array(
                    array( '', '', '', '', '' ),
                    array( '|X|', '', '', '', '' ),
                    array( '|X|', '', '', '', '' ),
                ),
                'message' => 'The block must fall on the bottom placed block'
            )
        );
    }

    /**
     * Tests that simulateData returns the expected simulation result.
     *
     * @dataProvider simulateDataProvider
     */
    public function testSimulateData( $data_to_simulate, $block_to_move, $expected, $message )
    {
        $this->assertEquals( $expected, $this->obj->simulateData( $data_to_simulate, $block_to_move ), $message );
    }
}