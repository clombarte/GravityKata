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
     * Representation of an ice block.
     *
     * @var string
     */
    const ICE_BLOCK = '|X|';

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

        if ( $block_to_move )
        {
            $data_to_simulate = $this->simulateBlockPush( $data_to_simulate, $block_to_move['x'], $block_to_move['y'] );
        }

        $data_to_simulate = $this->simulateFreeFallingBlocks( $data_to_simulate );

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
        $number_of_rows = count( $data_to_simulate );

        // Iterate rows backwards to find the lowest block to make it fall.
        for ( $row = $number_of_rows - 1; $row >= 0; $row-- )
        {
            for ( $column = 0; $column < count( $data_to_simulate[$row] ); $column++ )
            {
                if ( self::ICE_BLOCK == $data_to_simulate[$row][$column] )
                {
                    $i = $row;
                    $rows_to_fall = 0;
                    while ( isset( $data_to_simulate[$i + 1][$column] ) && self::EMPTY_SLOT == $data_to_simulate[$i + 1][$column] )
                    {
                        $i++;
                        $rows_to_fall++;
                    }

                    if ( $rows_to_fall > 0 )
                    {
                        $data_to_simulate[$row + $rows_to_fall][$column] = $data_to_simulate[$row][$column];
                        $data_to_simulate[$row][$column] = self::EMPTY_SLOT;
                    }
                }
            }
        }

        return $data_to_simulate;
    }

    /**
     * Simulates the push of a block or group of blocks from the left.
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
        else
        {
            $blocks_to_move = 1;
            for ( $column = $x; $column < count( $data_to_simulate[$y] ); $column++ )
            {
                if ( isset( $data_to_simulate[$y][$column + 1] ) && self::ICE_BLOCK == $data_to_simulate[$y][$column + 1] )
                {
                    $blocks_to_move++;
                }
            }

            if ( $blocks_to_move > 1 )
            {
                for ( $column = $x + 1; $blocks_to_move > 0; $blocks_to_move--, $column++ )
                {
                    $data_to_simulate[$y][$column] = self::ICE_BLOCK;

                    if ( $column == ( $x + 1 ) )
                    {
                        $data_to_simulate[$y][$column - 1] = self::EMPTY_SLOT;
                    }
                }
            }
        }

        return $data_to_simulate;
    }
}