<?php
spl_autoload_register(function ($className){
    include $_SERVER['DOCUMENT_ROOT'] . '/sudoku-solver/module/sudoku/' . $className . '.php';
});

$sudokuSize = 9;
$amountOfRows = $sudokuSize / 3;
$sudoku = new Sudoku($sudokuSize);
$blockTemplate = 'block.php';
?>

<form method="post">
    <div class="row justify-content-center">
        <div class="col-auto border border-dark">
            <?php
            foreach ($sudoku->getBlocks() as $block)
            {
                $blockId = $block->getId();

                if ($blockId === 0 || $blockId % $amountOfRows === 0)
                {
                    echo "<div class='row justify-content-center'>";
                }

                include $blockTemplate;

                if (($blockId + 1) % $amountOfRows === 0)
                {
                    echo "</div>";
                }
            }
            ?>
        </div>
    </div>
    <div class="row justify-content-center mt-4">
        <div class="col-auto">
            <button type="submit" name="solve" class="btn btn-primary">Solve</button>
        </div>
    </div>
</form>

<?php
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
            }
        }
    }
}
?>