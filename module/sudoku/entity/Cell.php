<?php
namespace SudokuSolver\sudoku\entity;

class Cell
{
    private int $id;
    private ?int $number = null;
    private bool $isSolved = false;
    private Row $row;
    private Column $column;
    private Block $block;

    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int|null
     */
    public function getNumber(): ?int
    {
        return $this->number;
    }

    /**
     * @param int|null $number
     */
    public function setNumber(?int $number): void
    {
        $this->number = $number;
    }

    /**
     * @return bool
     */
    public function isSolved(): bool
    {
        return $this->isSolved;
    }

    /**
     * @param bool $isSolved
     */
    public function setIsSolved(bool $isSolved): void
    {
        $this->isSolved = $isSolved;
    }

    /**
     * @return Row
     */
    public function getRow(): Row
    {
        return $this->row;
    }

    /**
     * @param Row $row
     */
    public function setRow(Row $row): void
    {
        $this->row = $row;
    }

    /**
     * @return Column
     */
    public function getColumn(): Column
    {
        return $this->column;
    }

    /**
     * @param Column $column
     */
    public function setColumn(Column $column): void
    {
        $this->column = $column;
    }

    /**
     * @return Block
     */
    public function getBlock(): Block
    {
        return $this->block;
    }

    /**
     * @param Block $block
     */
    public function setBlock(Block $block): void
    {
        $this->block = $block;
    }
}
