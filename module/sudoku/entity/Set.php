<?php
namespace SudokuSolver\Sudoku\Entity;

abstract class Set
{
    /**
     * @var int
     */
    protected int $id;

    /**
     * @var array<Cell>
     */
    protected array $cells = [];

    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * @return array<Cell>
     */
    public function getCells(): array
    {
        return $this->cells;
    }

    /**
     * @param Cell $cell
     */
    public function addCell(Cell $cell): void
    {
        $this->cells[] = $cell;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}
