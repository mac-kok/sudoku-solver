<?php

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

    public function __construct($size)
    {
        $this->init($size);
    }

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

    #[Pure]
    public function findCell($cellId): ?Cell
    {
        foreach ($this->cells as $cell) {
            if ($cell->getId() === $cellId)
            {
                return $cell;
            }
        }

        return null;
    }

    /**
     * Initializes empty sudoku
     * @param $size int The size of the sudoku (amount of blocks e.g. 9x9 cells = 9 blocks)
     * @return void
     */
    private function init(int $size)
    {
        $this->initCells($size * $size);
        $this->initRows($size);
        $this->initColumns($size);
        $this->initBlocks($size);
    }

    /**
     * Initializes empty cells
     * @param $amount int The amount of cells that should be initialized
     * @return void
     */
    private function initCells(int $amount)
    {
        for ($i = 0; $i < $amount; $i++)
        {
            $this->cells[] = new Cell($i);
        }
    }

    /**
     * Initializes rows and fills them with cells
     * @param $amount int The amount of rows that should be initialized
     * @return void
     */
    private function initRows(int $amount)
    {
        $minCell = 0;
        for ($i = 0; $i < $amount; $i++)
        {
            $this->rows[] = new Row($i);

            $maxCell = $minCell + $amount;
            for ($cell = $minCell; $cell < $maxCell; $cell++)
            {
                $this->rows[$i]->addCell($this->cells[$cell]);
                $this->cells[$cell]->setRow($this->rows[$i]);
            }

            $minCell += 9;
        }
    }

    /**
     * Initializes columns and fills them with cells
     * @param $amount int The amount of columns that should be initialized
     * @return void
     */
    private function initColumns(int $amount)
    {
        for ($i = 0; $i < $amount; $i++)
        {
            $this->columns[] = new Column($i);
        }

        foreach ($this->rows as $row)
        {
            for ($i = 0; $i < $amount; $i++)
            {
                $cell = $row->getCells()[$i];
                $cell->setColumn($this->columns[$i]);
                $this->columns[$i]->addCell($cell);
            }
        }
    }

    /**
     * Initializes blocks and fills them with cells
     * @param $amount int The amount of blocks that should be initialized
     * @return void
     */
    private function initBlocks(int $amount)
    {
        for ($i = 0; $i < $amount; $i++)
        {
            $this->blocks[] = new Block($i);
        }

        $minBlock = 0;
        $i = 0;
        foreach ($this->rows as $row)
        {
            if (($row->getId() + 1) % 3 === 0)
            {
                $minBlock += 3;
            }

            foreach ($row->getCells() as $cell)
            {
                $this->blocks[$i]->addCell($cell);
                $cell->setBlock($this->blocks[$i]);

                $columnId = $cell->getColumn()->getId();
                if (($columnId + 1) % 3 === 0)
                {
                    $i++;
                }

                if (($columnId + 1) % $amount === 0)
                {
                    $i = $minBlock;
                }
            }
        }
    }
}