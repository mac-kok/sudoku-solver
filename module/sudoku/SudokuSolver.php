<?php
namespace SudokuSolver\sudoku;

use SudokuSolver\sudoku\entity\Cell;
use SudokuSolver\sudoku\entity\Set;
use SudokuSolver\sudoku\entity\Sudoku;

class SudokuSolver
{
    /**
     * Solves a sudoku.
     * @param Sudoku $sudoku
     * @return void
     */
    public static function solve(Sudoku $sudoku): void
    {
        self::solveWithDeduction($sudoku);

        // Solves the rest of the sudoku with backtracking if there are no more cells with only one possible answer
        if (!$sudoku->isSolved()) {
            self::solveWithBacktracking($sudoku);
        }
    }

    /**
     * Solves a sudoku that only has one solution by recursively checking if a cell only has one possible answer.
     * @param Sudoku $sudoku
     * @return void
     */
    private static function solveWithDeduction(Sudoku $sudoku): void
    {
        $possibilities = self::getAllPossibilities($sudoku);

        $hasAnswer = false;
        foreach ($possibilities as $cellId => $possibility) {

            $cell = $sudoku->findCell($cellId);

            if ($cell !== null && count($possibility) === 1) {

                $cell->setNumber($possibility[0]);
                $cell->setIsSolved(true);
                $hasAnswer = true;
            }
        }

        if ($hasAnswer) {
            self::solveWithDeduction($sudoku);
        }
    }

    /**
     * Solves a sudoku through one by one assigning a valid number to an empty cell and backtracking when there are no
     * valid numbers available for the next cell.
     * @param Sudoku $sudoku
     * @return void
     */
    private static function solveWithBacktracking(Sudoku $sudoku): void
    {
        $cells = $sudoku->getAllUnsolvedCells();

        $i = 0;
        $triedPossibilities = [];
        while (!$sudoku->isSolved()) {

            $cell = $cells[$i];
            $possibilities = self::getPossibleNumbers($cell, $sudoku::SIZE);

            // Filter out all possibilities that have been tried before
            if (array_key_exists($i, $triedPossibilities)) {
                $possibilities = array_values(array_diff($possibilities, $triedPossibilities[$i]));
            } else {
                $triedPossibilities[$i] = [];
            }

            if (empty($possibilities)) {

                // Reset tried possibilities and number and go back to the previous cell
                unset($triedPossibilities[$i]);
                $cell->setNumber(null);
                $i--;
            } else {

                // Apply the next untried possibility and go to the next cell
                $number = $possibilities[0];
                $cell->setNumber($number);
                $triedPossibilities[$i][] = $number;

                $i++;
            }
        }
    }

    /**
     * Gets the possible answers of all the cells in a sudoku.
     * @param Sudoku $sudoku
     * @return array<int>
     */
    private static function getAllPossibilities(Sudoku $sudoku): array
    {
        $possibilities = [];

        foreach ($sudoku->getCells() as $cell) {

            if (!$cell->isSolved()) {
                $possibilities[$cell->getId()] = self::getPossibleNumbers($cell, $sudoku::SIZE);
            }
        }

        return $possibilities;
    }

    /**
     * Gets all possible answers of a cell.
     * @param Cell $cell
     * @param int $sudokuSize
     * @return array<int>
     */
    private static function getPossibleNumbers(Cell $cell, int $sudokuSize): array
    {
        $numbers = [];

        for ($i = 1; $i <= $sudokuSize; $i++) {

            $row = $cell->getRow();
            $column = $cell->getColumn();
            $block = $cell->getBlock();

            if (!self::numberInSet($i, $row) && !self::numberInSet($i, $column) &&
                !self::numberInSet($i, $block)) {
                $numbers[] = $i;
            }
        }

        return $numbers;
    }

    /**
     * Checks whether a number is already in a set.
     * @param int $number
     * @param Set $set
     * @return bool
     */
    private static function numberInSet(int $number, Set $set): bool
    {
        $inSet = false;

        foreach ($set->getCells() as $cell) {

            if ($cell->getNumber() === $number) {
                $inSet = true;
            }
        }

        return  $inSet;
    }
}
