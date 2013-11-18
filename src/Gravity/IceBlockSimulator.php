<?php

namespace Gravity;

/**
 * Simulates the movement of ice blocks when they are pushed to a particular direction.
 *
 * @author Carlos Lombarte <lombartec@gmail.com>
 */
class IceBlockSimulator
{
    /**
     * Takes care of all the process to simulate the input data.
     *
     * @param array $data_to_simulate   The input data to use to start the simulation.
     * @param array $block_to_move      The X and Y coordinates in the array for the block to move.
     *
     * @return array The data after the simulation.
     */
    public function simulateData( array $data_to_simulate, array $block_to_move = array() )
    {
        if ( !$block_to_move )
        {
            for ( $i = 0; $i < count( $data_to_simulate ); $i++ )
            {
                for ( $j = 0; $j < count( $data_to_simulate[$i] ); $j++ )
                {
                    if ( isset( $data_to_simulate[$i + 1][$j] ) && '' == $data_to_simulate[$i + 1][$j] )
                    {
                        $data_to_simulate[$i + 1][$j] = $data_to_simulate[$i][$j];
                        $data_to_simulate[$i][$j] = '';
                    }
                }
            }
        }
        else
        {
            if ( isset( $data_to_simulate[$block_to_move['y']][$block_to_move['x'] + 1] ) && '' == $data_to_simulate[$block_to_move['y']][$block_to_move['x'] + 1] )
            {
                $data_to_simulate[$block_to_move['y']][$block_to_move['x'] + 1] = $data_to_simulate[$block_to_move['y']][$block_to_move['x']];
                $data_to_simulate[$block_to_move['y']][$block_to_move['x']] = '';
            }
        }

        return $data_to_simulate;
    }
}