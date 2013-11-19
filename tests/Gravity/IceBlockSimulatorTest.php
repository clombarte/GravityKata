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
     * Tests that simulateData method returns an array as a result.
     */
    public function testThatSimulateReturnsAnArray()
    {
        $this->assertInternalType(
            \PHPUnit_Framework_Constraint_IsType::TYPE_ARRAY,
            $this->obj->simulateData( array() ),
            'This method must return an array containing the data after the simulation'
        );
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
                'expected' => array(
                    array( '', '', '', '' ),
                    array( '', '', '', '', '' ),
                    array( '|X|', '', '', '', '' ),
                ),
                'data_to_simulate' => array(
                    array( '|X|', '', '', '' ),
                    array( '', '', '', '', '' ),
                    array( '', '', '', '', '' ),
                ),
                'message' => 'The block must be at the bottom'
            ),
            'One block pushed from left' => array(
                'expected' => array(
                    array( '', '', '', '' ),
                    array( '', '', '', '', '' ),
                    array( '', '|X|', '', '', '' ),
                ),
                'data_to_simulate' => array(
                    array( '', '', '', '' ),
                    array( '', '', '', '', '' ),
                    array( '|X|', '', '', '', '' ),
                ),
                'message' => 'The block must move to the right'
            )
        );
    }

    /**
     * Tests that simulateData returns the expected simulation result.
     *
     * @dataProvider simulateDataProvider
     */
    public function testSimulateData( $expected, $data_to_simulate, $message )
    {
        $this->assertEquals( $expected, $this->obj->simulateData( $data_to_simulate ), $message );
    }
}