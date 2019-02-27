<?php
/** @var \DrdPlus\Calculators\Fall\FallWebPartsContainer $webPartsContainer */
$currentFallValues = $webPartsContainer->getCurrentFallValues();
?>
<h2 id="zraneni"><a href="#zraneni">Zranění</a></h2>
<div class="row">
  <div class="col-lg-2">
    <div class="alert alert-primary">
      <strong><?= $currentFallValues->getWoundsByFall() ?? '?'; ?></strong>
    </div>
  </div>
</div>