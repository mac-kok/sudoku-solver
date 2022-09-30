<?php
require_once __DIR__.'/vendor/autoload.php';

use SudokuSolver\sudoku\factory\SudokuFactory;
use SudokuSolver\form\CellInputApplier;
use SudokuSolver\sudoku\SudokuValidator;
use SudokuSolver\sudoku\SudokuSolver;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

// Specify Twig templates location
$loader = new FilesystemLoader(__DIR__ . '/templates');

// Instantiate Twig
$twig = new Environment($loader);

// Instantiate sudoku
$sudoku = SudokuFactory::build();
$amountOfRows = $sudoku::SIZE / 3;
$warningMsg = "";

// Process cell input and solve the sudoku
if (isset($_POST['solve'])) {
    CellInputApplier::apply($sudoku, $_POST['cell']);

    if (SudokuValidator::sudokuIsValid($sudoku)) {
        SudokuSolver::solve($sudoku);
    } else {
        $warningMsg = "This sudoku is invalid.";
    }
}

// Clear the sudoku
if (isset($_POST['clear'])) {
    $sudoku->clear();
}

// Render view
echo $twig->render('index.html.twig', [
    'sudoku' => $sudoku,
    'amount_of_rows' => $amountOfRows,
    'warning_msg' => $warningMsg
]);
