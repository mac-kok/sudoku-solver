<?php
global $cell;
?>

<div class='col'>
    <div class='square border'>
        <input name="cell[<?php echo $cell->getId() ?>]"  class='content text-center border-0 h-100' type='number' min='1' max='9'/>
    </div>
</div>