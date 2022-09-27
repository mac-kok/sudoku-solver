<?php
global $amountOfRows;
global $block;
$cellTemplate = 'cell.php';
?>

<div class="col-auto border border-dark">
    <?php
    foreach ($block->getCells() as $cell)
    {
        $cellId = $cell->getId();

        if ($cellId === 0 || $cellId % $amountOfRows === 0)
        {
            echo "<div class='row row-cols-$amountOfRows'>";
        }

        include $cellTemplate;

        if (($cellId + 1) % $amountOfRows === 0)
        {
            echo "</div>";
        }
    }
    ?>
</div>