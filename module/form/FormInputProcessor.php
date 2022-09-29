<?php
namespace SudokuSolver\Form;

use SudokuSolver\Sudoku\Entity\Sudoku;

class FormInputProcessor
{
    public static function processCellInput(Sudoku $sudoku, array $cells): void
    {
        foreach ($cells as $cellId => $cell) {
            if ($cell !== "") {
                $foundCell = $sudoku->findCell($cellId);
                if (!is_null($foundCell)) {
                    $foundCell->setNumber($cell);
                }
            }
        }
    }
}
