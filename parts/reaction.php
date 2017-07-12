<?php
namespace DrdPlus\Fight;

/** @var Controller $controller */
?>
<div class="block">
    <h2 id="akce_a_reakce"><a href="#akce_a_reakce" class="inner">Akce a reakce</a></h2>
    <div class="block">
        <div class="panel">
            <label>
                skočils <span class="hint">(pád tě nepřekvapil = výška -2 metry)</span>
                <input type="checkbox" name="<?= $controller::JUMP_IS_CONTROLLED ?>"
                       <?php if ($controller->isJumpControlled()) { ?>checked="checked" <?php } ?>>
            </label>
        </div>
    </div>
    <div class="block">
        <div class="panel">
            <label>neovládáš tělo <span class="hint">(obratnost = -6)</span>
                <input type="checkbox" name="<?= $controller::WITHOUT_REACTION ?>" value="1"
                       <?php if ($controller->isWithoutReaction()) { ?>checked="checked"<?php } ?>>
            </label>
        </div>
    </div>
    <div class="block">
        <div class="panel">
            <label>obratnost
                <input type="number" class="single-number" name="<?= $controller::AGILITY ?>" min="-40" max="40"
                       required value="<?= $controller->getSelectedAgility()->getValue() ?>">
            </label>
        </div>
    </div>
    <div class="block">
        <div class="panel">
            <label>smůla
                <input type="number" class="single-number" name="<?= $controller::ROLL_1D6 ?>" min="1" max="6"
                       required
                       value="<?= $controller->getSelectedLuck() ?>" placeholder="1k6"> <span class="hint">(1k6)</span>
            </label>
        </div>
    </div>
</div>
<div class="block"><input type="submit" value="Přepočítat"></div>
