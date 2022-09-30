<?php
namespace SudokuSolver\Sudoku\Entity;

use JetBrains\PhpStorm\Pure;

class Sudoku
{
    /**
     * @var array<Cell>
     */
    private array $cells = [];

    /**
     * @var array<Row>
     */
    private array $rows = [];

    /**
     * @var array<Column>
     */
    private array $columns = [];

    /**
     * @var array<Block>
     */
    private array $blocks = [];

    const SIZE = 9; // Currently, it only works with a normal 9 x 9 sudoku

    /**
     * @return array<Cell>
     */
    public function getCells(): array
    {
        return $this->cells;
    }

    /**
     * @return array<Row>
     */
    public function getRows(): array
    {
        return $this->rows;
    }

    /**
     * @return array<Column>
     */
    public function getColumns(): array
    {
        return $this->columns;
    }

    /**
     * @return array<Block>
     */
    public function getBlocks(): array
    {
        return $this->blocks;
    }

    /**
     * @param Cell[] $cells
     */
    public function setCells(array $cells): void
    {
        $this->cells = $cells;
    }

    /**
     * @param Row[] $rows
     */
    public function setRows(array $rows): void
    {
        $this->rows = $rows;
    }

    /**
     * @param Column[] $columns
     */
    public function setColumns(array $columns): void
    {
        $this->columns = $columns;
    }

    /**
     * @param Block[] $blocks
     */
    public function setBlocks(array $blocks): void
    {
        $this->blocks = $blocks;
    }

    #[Pure]
    public function findCell($cellId): ?Cell
    {
        foreach ($this->cells as $cell) {
            if ($cell->getId() === $cellId) {
                return $cell;
            }
        }

        return null;
    }

    public function clear(): void
    {
        foreach ($this->cells as $cell) {
            $cell->setNumber(null);
        }
    }
}
