<?php

// Load our autoloader
require_once __DIR__.'/vendor/autoload.php';
use Twig\Loader\FilesystemLoader;
use Twig\Environment;

// Specify our Twig templates location
$loader = new FilesystemLoader(__DIR__ . '/templates');

// Instantiate our Twig
$twig = new Environment($loader);

// Render our view
spl_autoload_register(function ($className){
    include $_SERVER['DOCUMENT_ROOT'] . '/sudoku-solver/module/sudoku/' . $className . '.php';
});

$sudoku = new Sudoku();
$amountOfRows = $sudoku::SIZE / 3;
$changedCells = [];

if (isset($_POST['solve']))
{
    foreach ($_POST['cell'] as $cellId => $cell)
    {
        if ($cell !== "")
        {
            $foundCell = $sudoku->findCell($cellId);
            if (!is_null($foundCell))
            {
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