<?php
    $nonet = 'nonet.php';
?>

<form method="post">
    <div class="row justify-content-center">
        <div class="col-auto border border-dark">
            <div class="row justify-content-center">
                <?php include $nonet ?>
                <?php include $nonet ?>
                <?php include $nonet ?>
            </div>
            <div class="row justify-content-center">
                <?php include $nonet ?>
                <?php include $nonet ?>
                <?php include $nonet ?>
            </div>
            <div class="row justify-content-center">
                <?php include $nonet ?>
                <?php include $nonet ?>
                <?php include $nonet ?>
            </div>
        </div>
    </div>
    <div class="row justify-content-center mt-4">
        <div class="col-auto">
            <button type="submit" name="solve" class="btn btn-primary">Solve</button>
        </div>
    </div>
</form>