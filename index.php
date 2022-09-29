<?php
require_once __DIR__.'/vendor/autoload.php';

use SudokuSolver\Sudoku\Factory\SudokuFactory;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

// Specify our Twig templates location
$loader = new FilesystemLoader(__DIR__ . '/templates');

// Instantiate our Twig
$twig = new Environment($loader);

// Render our view
$sudoku = SudokuFactory::build();
$amountOfRows = $sudoku::SIZE / 3;
$changedCells = [];

if (isset($_POST['solve'])) {
    foreach ($_POST['cell'] as $cellId => $cell) {
        if ($cell !== "") {
            $foundCell = $sudoku->findCell($cellId);
            if (!is_null($foundCell)) {
                $foundCell->setNumber($cell);
                $changedCells[] = $foundCell;
            }
        }
    }
}

echo $twig->render('index.html.twig', [
    'sudoku' => $sudoku,
    'amount_of_rows' => $amountOfRows
]);
