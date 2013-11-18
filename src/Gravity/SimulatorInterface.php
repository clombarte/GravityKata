<?php

namespace Gravity;

/**
 * Interface for classes that can make simulations from a set of data.
 *
 * @author Carlos Lombarte <lombartec@gmail.com>
 */
interface SimulatorInterface
{
    /**
     * Takes care of all the process to simulate the input data.
     *
     * @param array $data_to_simulate The input data to use to start the simulation.
     *
     * @return array The data after the simulation.
     */
    public function simulateData( array $data_to_simulate );
}