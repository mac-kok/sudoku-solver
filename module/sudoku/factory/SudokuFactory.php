<?php
namespace SudokuSolver\Sudoku\Factory;

use SudokuSolver\Sudoku\Entity\ {Sudoku, Cell, Row, Column, Block};

class SudokuFactory
{
    public static function build(): Sudoku
    {
        $sudoku = new Sudoku();

        self::buildCells($sudoku);
        self::buildRows($sudoku);
        self::buildColumns($sudoku);
        self::buildBlocks($sudoku);

        return $sudoku;
    }

    /**
     * Builds the cells of a sudoku
     * @param Sudoku $sudoku
     * @return void
     */
    private static function buildCells(Sudoku $sudoku): void
    {
        $cells = [];

        $size = $sudoku::SIZE * $sudoku::SIZE;
        for ($i = 0; $i < $size; $i++) {
            $cells[] = new Cell($i);
        }

        $sudoku->setCells($cells);
    }

    /**
     * Builds the rows of a sudoku and allocates the cells to them
     * @param Sudoku $sudoku
     * @return void
     */
    private static function buildRows(Sudoku $sudoku): void
    {
        $rows = [];

        $minCell = 0;
        for ($i = 0; $i < $sudoku::SIZE; $i++) {
            $rows[] = new Row($i);
            $cells = $sudoku->getCells();

            $maxCell = $minCell + $sudoku::SIZE;
            for ($cell = $minCell; $cell < $maxCell; $cell++) {
                $rows[$i]->addCell($cells[$cell]);
                $cells[$cell]->setRow($rows[$i]);
            }

            $minCell += $sudoku::SIZE;
        }

        $sudoku->setRows($rows);
    }

    /**
     * Builds the columns of a sudoku and allocates the cells to them
     * @param Sudoku $sudoku
     * @return void
     */
    private static function buildColumns(Sudoku $sudoku): void
    {
        $columns = [];
        $rows = $sudoku->getRows();

        for ($i = 0; $i < $sudoku::SIZE; $i++) {
            $columns[] = new Column($i);
        }

        foreach ($rows as $row) {
            for ($i = 0; $i < $sudoku::SIZE; $i++) {
                $cell = $row->getCells()[$i];
                $cell->setColumn($columns[$i]);
                $columns[$i]->addCell($cell);
            }
        }

        $sudoku->setColumns($columns);
    }

    /**
     * Builds the blocks of a sudoku and allocates the cells to them based on their row and column
     * @param Sudoku $sudoku
     * @return void
     */
    private static function buildBlocks(Sudoku $sudoku): void
    {
        $blocks = [];
        $rows = $sudoku->getRows();

        // Initialize blocks
        $blocksInRow = $sudoku::SIZE / 3;
        $amount = $blocksInRow * $blocksInRow;
        for ($block = 0; $block < $amount; $block++) {
            $blocks[] = new Block($block);
        }

        // Fill blocks with the correct cells based on row and column
        $minBlock = 0;
        $block = 0;
        foreach ($rows as $row) {
            // Increase minimum block ID when a row of blocks is filled
            if (($row->getId() + 1) % 3 === 0) {
                $amount = $sudoku::SIZE / 3;
                $minBlock += $amount;
            }

            foreach ($row->getCells() as $cell) {
                $blocks[$block]->addCell($cell);
                $cell->setBlock($blocks[$block]);

                // Increase block ID when 3 cells of a row have been allocated to a block
                $columnId = $cell->getColumn()->getId();
                if (($columnId + 1) % 3 === 0) {
                    $block++;
                }

                // Resets block ID to minimum block ID when all cells of a row have been allocated to a block
                if (($columnId + 1) % $sudoku::SIZE === 0) {
                    $block = $minBlock;
                }
            }
        }

        $sudoku->setBlocks($blocks);
    }
}
