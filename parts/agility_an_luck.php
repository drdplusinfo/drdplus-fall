<?php
namespace DrdPlus\Fight;

/** @var Controller $controller */
?>
<div class="block">
    <h2 id="obratnost_a_stesti"><a href="#obratnost_a_stesti" class="inner">Obratnost a štěstí</a></h2>
</div>
<div class="block">
    <div class="block">
        <div class="panel">
            <label for="agility">Obratnost</label>
        </div>
        <div class="panel">
            <input id="agility" type="number" name="<?= $controller::AGILITY ?>" min="-40" max="40"
                   value="<?= $controller->getSelectedAgility()->getValue() ?>">
        </div>
    </div>
    <div class="block">
        <div class="panel"><label for="luck">Štěstí</label></div>
        <div class="panel">
            <input id="luck" type="number" name="<?= $controller::LUCK ?>" min="1" max="6"
                   value="<?= $controller->getSelectedLuck() ?>" placeholder="1k6">
        </div>
    </div>
</div>
<div class="block"><input type="submit" value="Přepočítat"></div>
