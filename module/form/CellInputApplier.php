<?php
namespace SudokuSolver\Form;

use SudokuSolver\Sudoku\Entity\Sudoku;

class CellInputApplier
{
    /**
     * Applies all cell input from the form to a sudoku.
     * @param Sudoku $sudoku
     * @param array<int> $cellInput
     * @return void
     */
    public static function apply(Sudoku $sudoku, array $cellInput): void
    {
        foreach ($cellInput as $cellId => $number) {
            if ($number !== "") {
                $foundCell = $sudoku->findCell($cellId);
                if (!is_null($foundCell)) {
                    $foundCell->setNumber($number);
                    $foundCell->setIsSolved(true);
                }
            }
        }
    }
}
