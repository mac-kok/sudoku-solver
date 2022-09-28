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
        <div class="col-12 col-lg-6 border border-dark p-0">
            <?php
            foreach ($sudoku->getBlocks() as $block)
            {
                $blockId = $block->getId();

                if ($blockId === 0 || $blockId % $amountOfRows === 0)
                {
                    echo "<div class='row g-0'>";
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
    <div class="row justify-content-center mt-3 mb-3">
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