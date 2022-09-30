<?php
namespace SudokuSolver\sudoku\factory;

use SudokuSolver\sudoku\entity\ { Sudoku, Cell, Row, Column, Block };

class SudokuFactory
{
    /**
     * Builds a sudoku with empty cell numbers.
     * @return Sudoku
     */
    public static function build(): Sudoku
    {
        $sudoku = new Sudoku();

        self::buildCells($sudoku);
        self::buildSets($sudoku);
        self::fillSets($sudoku);

        return $sudoku;
    }

    /**
     * Builds the empty cells of a sudoku
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
     * Builds the empty sets of a sudoku.
     * @param Sudoku $sudoku
     * @return void
     */
    private static function buildSets(Sudoku $sudoku): void
    {
        $rows = [];
        $columns = [];
        $blocks = [];

        for ($i = 0; $i < $sudoku::SIZE; $i++) {
            $rows[] = new Row($i);
            $columns[] = new Column($i);
            $blocks[] = new Block($i);
        }

        $sudoku->setRows($rows);
        $sudoku->setColumns($columns);
        $sudoku->setBlocks($blocks);
    }

    /**
     * Fills all sets with cells.
     * @param Sudoku $sudoku
     * @return void
     */
    private static function fillSets(Sudoku $sudoku): void
    {
        self::fillRows($sudoku);
        self::fillColumns($sudoku);
        self::fillBlocks($sudoku);
    }

    /**
     * Fills all rows with cells.
     * @param Sudoku $sudoku
     * @return void
     */
    private static function fillRows(Sudoku $sudoku): void
    {
        $cells = $sudoku->getCells();

        $minCellId = 0;
        foreach ($sudoku->getRows() as $row) {
            $maxCellId = $minCellId + $sudoku::SIZE;
            for ($cellId = $minCellId; $cellId < $maxCellId; $cellId++) {
                $row->addCell($cells[$cellId]);
                $cells[$cellId]->setRow($row);
            }

            $minCellId += $sudoku::SIZE;
        }
    }

    /**
     * Fills all columns with cells.
     * @param Sudoku $sudoku
     * @return void
     */
    private static function fillColumns(Sudoku $sudoku): void
    {
        $rows = $sudoku->getRows();
        $columns = $sudoku->getColumns();

        foreach ($rows as $row) {
            for ($i = 0; $i < $sudoku::SIZE; $i++) {
                $cell = $row->getCells()[$i];

                $cell->setColumn($columns[$i]);
                $columns[$i]->addCell($cell);
            }
        }
    }

    /**
     * Fills all blocks with cells based on their row and column.
     * @param Sudoku $sudoku
     * @return void
     */
    private static function fillBlocks(Sudoku $sudoku): void
    {
        $blocks = $sudoku->getBlocks();
        $rows = $sudoku->getRows();

        $minBlockId = 0;
        $block = 0;
        foreach ($rows as $row) {
            // Increase minimum block ID when a row of blocks is filled
            if (($row->getId() + 1) % 3 === 0) {
                $amount = $sudoku::SIZE / 3;
                $minBlockId += $amount;
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
                    $block = $minBlockId;
                }
            }
        }
    }
}
