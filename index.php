<?php
require_once __DIR__.'/vendor/autoload.php';

use SudokuSolver\Sudoku\Factory\SudokuFactory;
use SudokuSolver\Form\FormInputProcessor;
use SudokuSolver\Sudoku\SudokuValidator;
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
    FormInputProcessor::processCellInput($sudoku, $_POST['cell']);

    if (!SudokuValidator::sudokuIsValid($sudoku)) {
        $warningMsg = "This sudoku is invalid.";
    }
}

// Render view
echo $twig->render('index.html.twig', [
    'sudoku' => $sudoku,
    'amount_of_rows' => $amountOfRows,
    'warning_msg' => $warningMsg
]);
