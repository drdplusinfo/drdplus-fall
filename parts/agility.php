<?php
namespace DrdPlus\Fight;

/** @var Controller $controller */
?>
<div class="block"><h2 id="Obratnost"><a href="#Obratnost" class="inner">Obratnost</a></h2></div>
<div class="block body-properties">
    <div class="panel">
        <div class="block"><label for="agility">Obratnost</label></div>
        <div class="block"><input id="agility" type="number" name="<?= $controller::AGILITY ?>" min="-40" max="40"
                                  value="<?= $controller->getSelectedAgility()->getValue() ?>"></div>
    </div>
</div>
<div class="block"><input type="submit" value="Přepočítat"></div>
