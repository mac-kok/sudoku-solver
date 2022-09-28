<?php
global $amountOfRows;
global $block;
$cellTemplate = 'cell.php';
?>

<div class="col border border-dark">
    <?php
    foreach ($block->getCells() as $cell)
    {
        $cellId = $cell->getId();

        if ($cellId === 0 || $cellId % 3 === 0)
        {
            echo "<div class='row g-0'>";
        }

        include $cellTemplate;

        if (($cellId + 1) % 3 === 0)
        {
            echo "</div>";
        }
    }
    ?>
</div>