<?php
namespace DrdPlus\Fight;

use DrdPlus\Codes\Transport\RidingAnimalCode;

/** @var Controller $controller */
?>
<div class="panel">
    <h2 id="pad"><a href="#pad">Pád</a></h2>
    <div class="block">
        <div class="panel">
            <label>
                <input type="radio" value="<?= $controller::HORSEBACK ?>"
                       name="<?= $controller::FALLING_FROM ?>"
                       <?php if ($controller->isFallingFromHorseback()) { ?>checked="checked" <?php } ?>>
                <strong>Padáš z "koně"</strong>
            </label>
            <label>
                <select name="<?= $controller::RIDING_ANIMAL_HEIGHT ?>">
                    <?php /**
                     * @var float $heightInMeters
                     * @var RidingAnimalCode $ridingAnimal
                     */
                    foreach ($controller->getRidingAnimalsWithHeight() as $heightInMeters => $ridingAnimal) { ?>
                        <option value="<?= $heightInMeters ?>"
                                <?php if ($controller->isRidingAnimalSelected($heightInMeters)) { ?>selected="selected"<?php } ?>>
                            <?= "{$ridingAnimal} ({$heightInMeters} m)" ?>
                        </option>
                    <?php } ?>
                </select>
            </label>
            <label>
                při skoku
                <input type="checkbox"
                       name="<?= $controller::HORSE_IS_JUMPING ?>"
                       <?php if ($controller->horseIsJumping()) { ?>checked="checked"<?php } ?>>
            </label>
        </div>
        <div class="panel">
        </div>
        <div class="block">
            <div class="panel">
                <label>
                    <input type="radio" value="<?= $controller::HEIGHT ?>"
                           name="<?= $controller::FALLING_FROM ?>"
                           <?php if ($controller->isFallingFromHeight()) { ?>checked="checked" <?php } ?>>
                    <strong>Padáš z výšky</strong>
                </label>
                <label>
                    <input type="number" name="<?= $controller::HEIGHT_OF_FALL ?>" class="few-numbers" min="0" max="999"
                           value="<?= $controller->getSelectedHeightOfFall()->getValue() ?>"
                           placeholder="v metrech"> metrů
                </label>
            </div>
        </div>
        <div class="block">
            <label>padáš na
                <select name="<?= $controller::SURFACE ?>">
                    <?php foreach ($controller->getSurfaces() as $surface) { ?>
                        <option value="<?= $surface->getValue() ?>"
                                <?php if ($controller->isSurfaceSelected($surface)) { ?>selected<?php } ?>>
                            <?= "{$surface->translateTo('cs')} ({$controller->getWoundsModifierBySurface($surface)})" ?></option>
                    <?php } ?>
                </select>
            </label>
        </div>
        <div class="block">
            <label>tvoje váha <span class="hint">včetně věcí, které spadly na tebe</span>
                <input name="<?= $controller::WEIGHT ?>" type="number" placeholder="váha v kg" class="few-numbers"
                       min="0" max="250"
                       value="<?= $controller->getSelectedWeight() ? $controller->getSelectedWeight()->getValue() : '' ?>">
            </label>
        </div>
        <div class="block"><input type="submit" value="Přepočítat"></div>
    </div>