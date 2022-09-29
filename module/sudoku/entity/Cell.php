<?php
namespace SudokuSolver\Sudoku\Entity;

class Cell
{
    private int $id;
    private ?int $number = null;
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
     * @return Row
     */
    public function getRow(): Row
    {
        return $this->row;
    }

    /**
     * @return Column
     */
    public function getColumn(): Column
    {
        return $this->column;
    }

    /**
     * @return Block
     */
    public function getBlock(): Block
    {
        return $this->block;
    }

    /**
     * @param int $number
     */
    public function setNumber(int $number): void
    {
        $this->number = $number;
    }

    /**
     * @param Row $row
     */
    public function setRow(Row $row): void
    {
        $this->row = $row;
    }

    /**
     * @param Column $column
     */
    public function setColumn(Column $column): void
    {
        $this->column = $column;
    }

    /**
     * @param Block $block
     */
    public function setBlock(Block $block): void
    {
        $this->block = $block;
    }
}
