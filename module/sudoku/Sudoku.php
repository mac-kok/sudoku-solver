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

    const SIZE = 9; // Currently only works with a normal 9 x 9 sudoku

    public function __construct()
    {
        $this->init();
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
     * @return void
     */
    private function init(): void
    {
        $this->initCells();
        $this->initRows();
        $this->initColumns();
        $this->initBlocks();
    }

    /**
     * Initializes empty cells
     * @return void
     */
    private function initCells(): void
    {
        $size = self::SIZE * self::SIZE;
        for ($i = 0; $i < $size; $i++)
        {
            $this->cells[] = new Cell($i);
        }
    }

    /**
     * Initializes rows and fills them with cells
     * @return void
     */
    private function initRows(): void
    {
        $minCell = 0;
        for ($i = 0; $i < self::SIZE; $i++)
        {
            $this->rows[] = new Row($i);

            $maxCell = $minCell + self::SIZE;
            for ($cell = $minCell; $cell < $maxCell; $cell++)
            {
                $this->rows[$i]->addCell($this->cells[$cell]);
                $this->cells[$cell]->setRow($this->rows[$i]);
            }

            $minCell += self::SIZE;
        }
    }

    /**
     * Initializes columns and fills them with cells
     * @return void
     */
    private function initColumns(): void
    {
        for ($i = 0; $i < self::SIZE; $i++)
        {
            $this->columns[] = new Column($i);
        }

        foreach ($this->rows as $row)
        {
            for ($i = 0; $i < self::SIZE; $i++)
            {
                $cell = $row->getCells()[$i];
                $cell->setColumn($this->columns[$i]);
                $this->columns[$i]->addCell($cell);
            }
        }
    }

    /**
     * Initializes blocks and fills them with cells
     * @return void
     */
    private function initBlocks(): void
    {
        $blocksInRow = self::SIZE / 3;
        $amount = $blocksInRow * $blocksInRow;
        // Initialize blocks
        for ($block = 0; $block < $amount; $block++)
        {
            $this->blocks[] = new Block($block);
        }

        // Fill blocks with the correct cells based on row and column
        $minBlock = 0;
        $block = 0;
        foreach ($this->rows as $row)
        {
            // Increase minimum block ID when a row of blocks is filled
            if (($row->getId() + 1) % 3 === 0)
            {
                $amount = self::SIZE / 3;
                $minBlock += $amount;
            }

            foreach ($row->getCells() as $cell)
            {
                $this->blocks[$block]->addCell($cell);
                $cell->setBlock($this->blocks[$block]);

                // Increase block ID when 3 cells of a row have been allocated to a block
                $columnId = $cell->getColumn()->getId();
                if (($columnId + 1) % 3 === 0)
                {
                    $block++;
                }

                // Resets block ID to minimum block ID when all cells of a row have been allocated to a block
                if (($columnId + 1) % self::SIZE === 0)
                {
                    $block = $minBlock;
                }
            }
        }
    }
}