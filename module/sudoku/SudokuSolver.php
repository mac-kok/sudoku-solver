<?php
namespace SudokuSolver\Sudoku;

use SudokuSolver\Sudoku\Entity\Cell;
use SudokuSolver\Sudoku\Entity\Set;
use SudokuSolver\Sudoku\Entity\Sudoku;

class SudokuSolver
{
    /**
     * Solves a sudoku.
     * @param Sudoku $sudoku
     * @return void
     */
    public static function solve(Sudoku $sudoku): void
    {
        self::solveWithPossibilities($sudoku);
    }

    /**
     * Solves a sudoku that only has one solution by recursively checking if a cell only has one possible answer.
     * @param Sudoku $sudoku
     * @return void
     */
    private static function solveWithPossibilities(Sudoku $sudoku): void
    {
        $possibilities = self::getAllPossibilities($sudoku);

        $hasAnswer = false;
        foreach ($possibilities as $cellId => $possibility) {
            $cell = $sudoku->findCell($cellId);

            if ($cell !== null && count($possibility) === 1) {
                $cell->setNumber($possibility[0]);
                $hasAnswer = true;
            }
        }

        if ($hasAnswer) {
            self::solveWithPossibilities($sudoku);
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
            if ($cell->getNumber() === null) {
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

            if (self::numberIsPossible($i, $row) && self::numberIsPossible($i, $column) &&
                self::numberIsPossible($i, $block)) {
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
    private static function numberIsPossible(int $number, Set $set): bool
    {
        $possible = true;

        foreach ($set->getCells() as $cell) {
            if ($cell->getNumber() === $number) {
                $possible = false;
            }
        }

        return  $possible;
    }
}
