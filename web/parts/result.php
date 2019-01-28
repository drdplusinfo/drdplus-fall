<?php
/** @var \DrdPlus\Calculators\Fall\CurrentFallValues $currentFallValues */
?>
<h2 id="zraneni"><a href="#zraneni">Zranění</a></h2>
<div class="row">
  <div class="col-sm-1">
    <strong id="result" class="message warning"><?= $currentFallValues->getWoundsByFall() ?? '?'; ?></strong>
  </div>
</div>