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
     * The data to use to make the simulation.
     *
     * @var array
     */
    private $data_to_simulate;

    /**
     * Takes care of all the process to simulate the input data.
     *
     * @param array $data_to_simulate   The data to use to make the simulation.
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

        $this->data_to_simulate = $data_to_simulate;

        if ( $block_to_move && self::EMPTY_SLOT != $this->data_to_simulate[$block_to_move['y']][$block_to_move['x']] )
        {
            $this->simulateMultipleBlockPush( $block_to_move['x'], $block_to_move['y'] );
            $this->simulateUniqueBlockPush( $block_to_move['x'], $block_to_move['y'] );
        }

        $this->simulateFreeFallingBlocks();

        return $this->data_to_simulate;
    }

    /**
     * Simulates the free falling of blocks that does not have anything below them.
     */
    private function simulateFreeFallingBlocks()
    {
        $number_of_rows = count( $this->data_to_simulate );

        // Iterate rows backwards to find the lowest block to make it fall.
        for ( $row = $number_of_rows - 1; $row >= 0; $row-- )
        {
            for ( $column = 0; $column < count( $this->data_to_simulate[$row] ); $column++ )
            {
                if ( self::ICE_BLOCK == $this->data_to_simulate[$row][$column] )
                {
                    $rows_to_fall = $this->getNumberOfRowsToFallForABlock( $row, $column );

                    if ( $rows_to_fall > 0 )
                    {
                        $this->data_to_simulate[$row + $rows_to_fall][$column]    = self::ICE_BLOCK;
                        $this->data_to_simulate[$row][$column]                    = self::EMPTY_SLOT;
                    }
                }
            }
        }
    }

    /**
     * Gets the total number of rows that a block has to fall to be in top of the ground or another block.
     *
     * @param integer   $current_row        The row where the block is falling.
     * @param integer   $column             The column where the block is falling.
     *
     * @return integer The number of rows that a block has to fall.
     */
    private function getNumberOfRowsToFallForABlock( $current_row, $column )
    {
        $rows_to_fall = 0;

        while ( isset( $this->data_to_simulate[$current_row + 1][$column] ) && self::EMPTY_SLOT == $this->data_to_simulate[$current_row + 1][$column] )
        {
            $current_row++;
            $rows_to_fall++;
        }

        return $rows_to_fall;
    }

    /**
     * Simulates the push of a group of blocks from the left when the block has one or more blocks in his near right.
     *
     * @param integer   $x                  The index of the column.
     * @param integer   $y                  The index of the row.
     */
    private function simulateMultipleBlockPush( $x, $y )
    {
        if ( isset( $this->data_to_simulate[$y][$x + 1] ) && self::ICE_BLOCK == $this->data_to_simulate[$y][$x + 1] )
        {
            $blocks_to_move = $this->getNumberOfBlocksTogetherToMove( $x, $y );
            $column         = $x + 1;

            if ( isset( $this->data_to_simulate[$y][$blocks_to_move + $column] ) )
            {
                for ( ; $blocks_to_move > 0; $blocks_to_move--, $column++ )
                {
                    $this->data_to_simulate[$y][$column] = self::ICE_BLOCK;

                    if ( $column == ( $x + 1 ) )
                    {
                        $this->data_to_simulate[$y][$column - 1] = self::EMPTY_SLOT;
                    }
                }
            }
        }
    }

    /**
     * Returns the number of blocks in a row we have to push to the right.
     *
     * @param integer   $x                  The block X axis origin of the push force.
     * @param integer   $y                  The block Y axis origin of the push force.
     *
     * @return integer The number of grouped blocks that have to be moved.
     */
    private function getNumberOfBlocksTogetherToMove( $x, $y )
    {
        $blocks_to_move = 0;

        for ( $column = $x; $column < count( $this->data_to_simulate[$y] ); $column++ )
        {
            if ( isset( $this->data_to_simulate[$y][$column + 1] ) && self::ICE_BLOCK == $this->data_to_simulate[$y][$column + 1] )
            {
                $blocks_to_move++;
            }
        }

        return ( $blocks_to_move > 0 ) ? ++$blocks_to_move : $blocks_to_move ;
    }

    /**
     * Simulates the push of a block from the left when the block does not have another block at his near right.
     *
     * @param integer   $x                  The index of the column.
     * @param integer   $y                  The index of the row.
     */
    private function simulateUniqueBlockPush( $x, $y )
    {
        if ( isset( $this->data_to_simulate[$y][$x + 1] ) && self::EMPTY_SLOT == $this->data_to_simulate[$y][$x + 1] )
        {
            $this->data_to_simulate[$y][$x + 1]   = self::ICE_BLOCK;
            $this->data_to_simulate[$y][$x]       = self::EMPTY_SLOT;
        }
    }
}