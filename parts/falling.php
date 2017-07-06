<?php
namespace DrdPlus\Fight;

use DrdPlus\Codes\Transport\RidingAnimalCode;

/** @var Controller $controller */
?>
<div class="panel">
    <h2 id="Výška pádu"><a href="#Výška pádu">Výška pádu</a></h2>
    <div class="panel">
        <div class="block">
            <label>
                <input type="radio" value="<?= $controller::FALLING_FROM_HORSEBACK ?>"
                       name="<?= $controller::FALLING_FROM ?>"
                       <?php if ($controller->isFallingFromHorseback()) { ?>checked="checked" <?php } ?>>
                Padáš z "koně"
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
        <div class="block">
            <label>při skoku <input type="checkbox" name="<?= $controller::JUMPING ?>" value="1"
                                    <?php if ($controller->isJumping()) { ?>checked<?php } ?>></label>
        </div>
    </div>
    <div class="panel">
        <div class="block">
            <label>
                Padáš z výšky
                <input type="radio" value="<?= $controller::FALLING_FROM_HEIGHT ?>"
                       name="<?= $controller::FALLING_FROM ?>"
                       <?php if ($controller->isFallingFromHeight()) { ?>checked="checked" <?php } ?>>
            </label>
        </div>
        <div class="block"><label>výška <input type="number" name="<?= $controller::HEIGHT_OF_FALL ?>"> metrů</label>
        </div>
    </div>
    <div class="block"><input type="submit" value="Přepočítat"></div>
</div>