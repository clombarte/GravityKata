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
     * Tests that simulate method returns an array as a result.
     */
    public function testThatSimulateReturnsAnArray()
    {
        $obj = new IceBlockSimulator();
        $this->assertInternalType(
            \PHPUnit_Framework_Constraint_IsType::TYPE_ARRAY,
            $obj->simulate(),
            'This method must return an array containing the data after the simulation'
        );
    }
}