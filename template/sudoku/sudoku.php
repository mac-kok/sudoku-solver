<?php
    $block = 'block.php';
?>

<form method="post">
    <div class="row justify-content-center">
        <div class="col-auto border border-dark">
            <div class="row justify-content-center">
                <?php include $block ?>
                <?php include $block ?>
                <?php include $block ?>
            </div>
            <div class="row justify-content-center">
                <?php include $block ?>
                <?php include $block ?>
                <?php include $block ?>
            </div>
            <div class="row justify-content-center">
                <?php include $block ?>
                <?php include $block ?>
                <?php include $block ?>
            </div>
        </div>
    </div>
    <div class="row justify-content-center mt-4">
        <div class="col-auto">
            <button type="submit" name="solve" class="btn btn-primary">Solve</button>
        </div>
    </div>
</form>