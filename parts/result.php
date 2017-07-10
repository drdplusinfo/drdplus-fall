<?php
namespace DrdPlus\Fight;

/** @var Controller $controller */
?>
<div class="block">
    <h2 id="zraneni"><a href="#zraneni">Zranění</a></h2>
</div>
<div class="block">
    <strong><?= $controller->getWoundsByFall() ?? '?'; ?></strong>
</div>