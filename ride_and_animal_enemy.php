<?php
namespace DrdPlus\Fight;

use DrdPlus\Codes\Skills\PhysicalSkillCode;
use DrdPlus\Codes\Skills\PsychicalSkillCode;
use DrdPlus\Codes\Transport\RidingAnimalCode;
use DrdPlus\Tables\Measurements\Distance\Distance;

/** @var Controller $controller */
?>
<div class="panel">
    <div class="block">
        <label>
            <input type="checkbox" value="1"
                   name="<?= $controller::ON_HORSEBACK ?>"
                   <?php if ($controller->getSelectedOnHorseback()) { ?>checked="checked" <?php } ?>>
            Padáš z "koně"
        </label>
        <label>
            "Kůň"
            <select name="riding-animal">
                <?php /**
                 * @var float $heightInMeters
                 * @var RidingAnimalCode $ridingAnimal
                 */
                foreach ($controller->getRidingAnimalsWithHeight() as $heightInMeters => $ridingAnimal) { ?>
                    <option value="<?= $ridingAnimal ?>"><?= "{$ridingAnimal} ({$heightInMeters} m)" ?></option>
                <?php } ?>
            </select>
        </label>
    </div>
    <div class="block"><input type="submit" value="Přepočítat"></div>
</div>