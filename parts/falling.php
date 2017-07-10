<?php
namespace DrdPlus\Fight;

use DrdPlus\Codes\Transport\RidingAnimalCode;

/** @var Controller $controller */
?>
<div class="panel">
    <h2 id="pad"><a href="#pad">Pád</a></h2>
    <div class="panel">
        <div class="block">
            <label>
                <input type="radio" value="<?= $controller::FALLING_FROM_HORSEBACK ?>"
                       name="<?= $controller::FALLING_FROM ?>"
                       <?php if ($controller->isFallingFromHorseback()) { ?>checked="checked" <?php } ?>>
                <strong>Padáš z "koně"</strong>
            </label>
        </div>
        <div class="block">
            <label>
                "kůň"
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
        </div>
        <div class="block">
            <label>
                pohyb
                <select name="<?= $controller::RIDING_MOVEMENT ?>">
                    <?php
                    foreach ($controller->getRidingAnimalMovements() as $ridingAnimalMovement) { ?>
                        <option value="<?= $ridingAnimalMovement->getValue() ?>"
                                <?php if ($controller->isRidingAnimalMovementSelected($ridingAnimalMovement)) { ?>selected="selected"<?php } ?>
                        >
                            <?= $ridingAnimalMovement->translateTo('cs') ?>
                        </option>
                    <?php } ?>
                </select>
            </label>
        </div>
    </div>
    <div class="panel">
        <div class="block">
            <label>
                <input type="radio" value="<?= $controller::FALLING_FROM_HEIGHT ?>"
                       name="<?= $controller::FALLING_FROM ?>"
                       <?php if ($controller->isFallingFromHeight()) { ?>checked="checked" <?php } ?>>
                <strong>Padáš z výšky</strong>
            </label>
        </div>
        <div class="block">
            <label>výška <input type="number" name="<?= $controller::HEIGHT_OF_FALL ?>" class="few-numbers"
                                               placeholder="v metrech"></label>
        </div>
    </div>
    <div class="block">
        <label>padáš do
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
            <input name="<?= $controller::WEIGHT ?>" type="number" placeholder="váha v kg" class="few-numbers" min="0" max="250"
                   value="<?= $controller->getSelectedWeight() ? $controller->getSelectedWeight()->getValue() : '' ?>">
        </label>
    </div>
    <div class="block"><input type="submit" value="Přepočítat"></div>
</div>