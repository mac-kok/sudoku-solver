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

    private int $size;

    public function __construct($size)
    {
        $this->size = $size;
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
        $size = $this->size * $this->size;
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
        for ($i = 0; $i < $this->size; $i++)
        {
            $this->rows[] = new Row($i);

            $maxCell = $minCell + $this->size;
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
     * @return void
     */
    private function initColumns(): void
    {
        for ($i = 0; $i < $this->size; $i++)
        {
            $this->columns[] = new Column($i);
        }

        foreach ($this->rows as $row)
        {
            for ($i = 0; $i < $this->size; $i++)
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
        for ($i = 0; $i < $this->size; $i++)
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

                if (($columnId + 1) % $this->size === 0)
                {
                    $i = $minBlock;
                }
            }
        }
    }
}