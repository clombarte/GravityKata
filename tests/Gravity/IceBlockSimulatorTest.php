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
            'Multiple blocks fall' => array(
                'data_to_simulate' => array(
                    array( '|X|', '|X|', '', '|X|', '|X|' ),
                    array( '', '', '', '', '' ),
                    array( '', '', '', '', '' ),
                ),
                'block_to_move' => array(),
                'expected' => array(
                    array( '', '', '', '', '' ),
                    array( '', '', '', '', '' ),
                    array( '|X|', '|X|', '', '|X|', '|X|' ),
                ),
                'message' => 'The blocks must fall to the bottom'
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
            ),
            'Push block and the block over it falls' => array(
                'data_to_simulate' => array(
                    array( '', '', '', '', '' ),
                    array( '|X|', '', '', '', '' ),
                    array( '|X|', '', '', '', '' ),
                ),
                'block_to_move' => array(
                    'x' => 0,
                    'y' => 2
                ),
                'expected' => array(
                    array( '', '', '', '', '' ),
                    array( '', '', '', '', '' ),
                    array( '|X|', '|X|', '', '', '' ),
                ),
                'message' => 'The block must fall where the below block was positioned'
            ),
            'Two blocks falling in top of each other' => array(
                'data_to_simulate' => array(
                    array( '|X|', '', '', '', '' ),
                    array( '|X|', '', '', '', '' ),
                    array( '', '', '', '', '' ),
                ),
                'block_to_move' => array(),
                'expected' => array(
                    array( '', '', '', '', '' ),
                    array( '|X|', '', '', '', '' ),
                    array( '|X|', '', '', '', '' ),
                ),
                'message' => 'Both blocks must fall'
            ),
            'Multiple blocks falling in top of each other' => array(
                'data_to_simulate' => array(
                    array( '|X|' ),
                    array( '' ),
                    array( '' ),
                    array( '|X|' ),
                    array( '|X|' ),
                    array( '|X|' ),
                    array( '' ),
                ),
                'block_to_move' => array(),
                'expected' => array(
                    array( '' ),
                    array( '' ),
                    array( '' ),
                    array( '|X|' ),
                    array( '|X|' ),
                    array( '|X|' ),
                    array( '|X|' ),
                ),
                'message' => 'Both blocks must fall'
            ),
            'Push block with another block next to it' => array(
                'data_to_simulate' => array(
                    array( '', '', '', '', '' ),
                    array( '', '', '', '', '' ),
                    array( '|X|', '|X|', '', '', '' ),
                ),
                'block_to_move' => array(
                    'x' => 0,
                    'y' => 2
                ),
                'expected' => array(
                    array( '', '', '', '', '' ),
                    array( '', '', '', '', '' ),
                    array( '', '|X|', '|X|', '', '' ),
                ),
                'message' => 'Both blocks must move one place to their right'
            ),
            'Push multiple blocks and one falls' => array(
                'data_to_simulate' => array(
                    array( '', '', '', '', '' ),
                    array( '|X|', '|X|', '', '|X|', '' ),
                    array( '|X|', '|X|', '', '|X|', '|X|' ),
                ),
                'block_to_move' => array(
                    'x' => 0,
                    'y' => 1
                ),
                'expected' => array(
                    array( '', '', '', '', '' ),
                    array( '', '|X|', '', '|X|', '' ),
                    array( '|X|', '|X|', '|X|', '|X|', '|X|' ),
                ),
                'message' => 'There has to be 2 blocks on top and the bottom full'
            ),
            'Push block out of limits' => array(
                'data_to_simulate' => array(
                    array( '', '', '', '', '' ),
                    array( '', '', '', '', '' ),
                    array( '', '', '', '', '|X|' ),
                ),
                'block_to_move' => array(
                    'x' => 4,
                    'y' => 2
                ),
                'expected' => array(
                    array( '', '', '', '', '' ),
                    array( '', '', '', '', '' ),
                    array( '', '', '', '', '|X|' ),
                ),
                'message' => 'This block should not be able to be pushed from this position'
            ),
        );
    }

    /**
     * Tests that simulateData returns the expected simulation result.
     *
     * @param array     $data_to_simulate   The data to use in the simulation.
     * @param array     $block_to_move      The block in X and Y axis to push.
     * @param array     $expected           The expected data after the simulation.
     * @param string    $message            The error message when the test fails.
     *
     * @dataProvider simulateDataProvider
     */
    public function testSimulateData( $data_to_simulate, $block_to_move, $expected, $message )
    {
        $this->assertEquals( $expected, $this->obj->simulateData( $data_to_simulate, $block_to_move ), $message );
    }
}