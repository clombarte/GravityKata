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
     * Representation of an slot without any block
     *
     * @var string
     */
    const EMPTY_SLOT = '';

    /**
     * Takes care of all the process to simulate the input data.
     *
     * @param array $data_to_simulate   The input data to use to start the simulation.
     * @param array $block_to_move      The X and Y coordinates in the array for the block to move.
     *
     * @throws EmptySimulationDataException when the $data_to_simulate array is empty.
     *
     * @return array The data after the simulation.
     */
    public function simulateData( array $data_to_simulate, array $block_to_move = array() )
    {
        if ( !$data_to_simulate )
        {
            throw new EmptySimulationDataException();
        }

        if ( !$block_to_move )
        {
            $data_to_simulate = $this->simulateFreeFallingBlocks( $data_to_simulate );
        }
        else
        {
            $data_to_simulate = $this->simulateBlockPush( $data_to_simulate, $block_to_move['x'], $block_to_move['y'] );
        }

        return $data_to_simulate;
    }

    /**
     * Simulates the free falling of blocks that does not have anything below them.
     *
     * @param array $data_to_simulate The input data to use for the simulation.
     *
     * @return array The resulting simulated free fall.
     */
    private function simulateFreeFallingBlocks( $data_to_simulate )
    {
        for ( $i = 0; $i < count( $data_to_simulate ); $i++ )
        {
            for ( $j = 0; $j < count( $data_to_simulate[$i] ); $j++ )
            {
                if ( isset( $data_to_simulate[$i + 1][$j] ) && self::EMPTY_SLOT == $data_to_simulate[$i + 1][$j] )
                {
                    $data_to_simulate[$i + 1][$j] = $data_to_simulate[$i][$j];
                    $data_to_simulate[$i][$j] = self::EMPTY_SLOT;
                }
            }
        }

        return $data_to_simulate;
    }

    /**
     * Simulates the push of a block from the left.
     *
     * @param array     $data_to_simulate   The input data to use for the simulation.
     * @param integer   $x                  The index of the column.
     * @param integer   $y                  The index of the row.
     *
     * @return array The resulting simulated block push.
     */
    private function simulateBlockPush( $data_to_simulate, $x, $y )
    {
        if ( isset( $data_to_simulate[$y][$x + 1] ) && self::EMPTY_SLOT == $data_to_simulate[$y][$x + 1] )
        {
            $data_to_simulate[$y][$x + 1] = $data_to_simulate[$y][$x];
            $data_to_simulate[$y][$x] = self::EMPTY_SLOT;
        }

        return $data_to_simulate;
    }
}