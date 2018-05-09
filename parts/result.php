<?php
/** @var \DrdPlus\Calculator\Fall\FallController $controller */
?>
<div>
  <h2 id="zraneni"><a href="#zraneni">Zranění</a></h2>
  <strong id="result"><?= $controller->getWoundsByFall() ?? '?'; ?></strong>
</div>