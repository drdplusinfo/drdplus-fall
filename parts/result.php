<?php
namespace DrdPlus\Fight;

/** @var Controller $controller */
?>
<div class="block">
    <div class="panel">
        <h2 id="result"><a href="#result">Výsledek</a></h2>
    </div>
    <div class="panel">
        Zranění <?= $controller->getWoundsByFall(); ?>
    </div>
</div>