<?php

namespace SudokuSolver\Sudoku;

use SudokuSolver\Sudoku\Entity\Set;
use SudokuSolver\Sudoku\Entity\Sudoku;

class SudokuValidator
{
    public static function sudokuIsValid(Sudoku $sudoku): bool
    {
        $valid = true;
        $sudokuSize = $sudoku::SIZE;

        foreach ($sudoku->getRows() as $row) {
            if (!self::isValidSet($row, $sudokuSize)) {
                $valid = false;
            }
        }

        foreach ($sudoku->getColumns() as $column) {
            if (!self::isValidSet($column, $sudokuSize)) {
                $valid = false;
            }
        }

        foreach ($sudoku->getBlocks() as $block) {
            if (!self::isValidSet($block, $sudokuSize)) {
                $valid = false;
            }
        }

        return $valid;
    }

    private static function isValidSet(Set $set, int $sudokuSize): bool
    {
        $valid = true;

        if (!self::hasUniqueNumbers($set) || !self::hasValidNumbers($set, $sudokuSize)) {
            $valid = false;
        }

        return $valid;
    }

    private static function hasUniqueNumbers(Set $set): bool
    {
        $numbers = [];

        foreach ($set->getCells() as $cell) {
            $number = $cell->getNumber();

            if ($number !== null) {
                $numbers[] = $number;
            }
        }

        return count($numbers) === count(array_unique($numbers));
    }

    private static function hasValidNumbers(Set $set, int $sudokuSize): bool
    {
        $valid = true;

        foreach ($set->getCells() as $cell) {
            $number = $cell->getNumber();

            if ($number !== null && ($number < 1 || $number > $sudokuSize)) {
                $valid = false;
            }
        }

        return $valid;
    }
}
