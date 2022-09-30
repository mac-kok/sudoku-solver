<?php

namespace SudokuSolver\sudoku;

use SudokuSolver\Sudoku\Entity\Set;
use SudokuSolver\Sudoku\Entity\Sudoku;

class SudokuValidator
{
    /**
     * Checks whether a sudoku is valid.
     * @param Sudoku $sudoku
     * @return bool
     */
    public static function sudokuIsValid(Sudoku $sudoku): bool
    {
        $valid = true;

        if (!self::setsAreValid($sudoku->getRows(), $sudoku::SIZE) ||
            !self::setsAreValid($sudoku->getColumns(), $sudoku::SIZE) ||
            !self::setsAreValid($sudoku->getBlocks(), $sudoku::SIZE)) {
            $valid = false;
        }

        return $valid;
    }

    /**
     * Checks whether the sets in a given array are valid.
     * @param array<Set> $sets
     * @param int $sudokuSize
     * @return bool
     */
    private static function setsAreValid(array $sets, int $sudokuSize): bool
    {
        $valid = true;

        foreach ($sets as $set) {
            if (!self::hasUniqueNumbers($set) || !self::hasValidNumbers($set, $sudokuSize)) {
                $valid = false;
            }
        }

        return $valid;
    }

    /**
     * Checks whether a set has unique numbers.
     * @param Set $set
     * @return bool
     */
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

    /**
     * Checks whether a set has valid numbers.
     * @param Set $set
     * @param int $sudokuSize
     * @return bool
     */
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
