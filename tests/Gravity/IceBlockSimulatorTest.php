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
     * Tests that simulateData method returns an array as a result.
     */
    public function testThatSimulateReturnsAnArray()
    {
        $obj = new IceBlockSimulator();
        $this->assertInternalType(
            \PHPUnit_Framework_Constraint_IsType::TYPE_ARRAY,
            $obj->simulateData( array() ),
            'This method must return an array containing the data after the simulation'
        );
    }

    /**
     * Tests that simulateData returns the expected simulation result.
     */
    public function testThatSimulateReturnsTheExpectedSimulationResult()
    {
        $expected = array(
            array( '', '', '', '' ),
            array( '', '', '', '', '' ),
            array( '|X|', '', '', '', '' ),
        );

        $data_to_simulate = array(
            array( '|X|', '', '', '' ),
            array( '', '', '', '', '' ),
            array( '', '', '', '', '' ),
        );

        $obj = new IceBlockSimulator();
        $this->assertEquals( $expected, $obj->simulateData( $data_to_simulate ), 'This method is not returning the expected simulation result' );
    }
}