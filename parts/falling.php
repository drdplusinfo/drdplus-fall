<?php
use DrdPlus\Codes\Transport\RidingAnimalCode;

/** @var \DrdPlus\FallCalculator\FallController $controller */
?>
<div class="row">
  <h2 id="pad" class="col"><a href="#pad">Pád</a></h2>
</div>
<div class="row">
  <div class="col">
    <div>
      <label>
        <input id="onHorseback" type="radio" value="<?= $controller::HORSEBACK ?>"
               name="<?= $controller::FALLING_FROM ?>"
               required
               <?php if ($controller->isFallingFromHorseback()) { ?>checked="checked" <?php } ?>>
        <strong>padáš z "koně"</strong>
      </label>
      <label>
        <select class="horse-related" name="<?= $controller::HORSE_HEIGHT ?>">
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
        při jeho skoku
        <input type="checkbox" class="horse-related"
               name="<?= $controller::HORSE_IS_JUMPING ?>"
               <?php if ($controller->isHorseJumping()) { ?>checked="checked"<?php } ?>>
      </label>
    </div>
    <div>
      <label>
        pohyb koně
        <select name="<?= $controller::RIDING_MOVEMENT ?>" class="horse-related">
            <?php foreach ($controller->getRidingAnimalMovements() as $ridingAnimalMovement) { ?>
              <option value="<?= $ridingAnimalMovement->getValue() ?>"
                      <?php if ($controller->isRidingAnimalMovementSelected($ridingAnimalMovement)) { ?>selected<?php } ?>>
                  <?= $ridingAnimalMovement->translateTo('cs') . " (+{$controller->getBaseOfWoundsModifierByMovement($ridingAnimalMovement, false)} ZZ)" ?>
              </option>
            <?php } ?>
        </select>
      </label>
    </div>
    <div>
    </div>
    <div>
      <div>
        <label>
          <input type="radio" value="<?= $controller::HEIGHT ?>" id="fallingFromHeight"
                 name="<?= $controller::FALLING_FROM ?>" required
                 <?php if ($controller->isFallingFromHeight()) { ?>checked="checked" <?php } ?>>
          <strong>padáš z výšky</strong>
        </label>
        <label>
          <input type="number" name="<?= $controller::HEIGHT_OF_FALL ?>" class="few-numbers height-related" min="0" max="999"
                 value="<?= $controller->getSelectedHeightOfFall()->getValue() ?>" placeholder="v metrech">
          metrů
        </label>
      </div>
    </div>
    <div>
      <label>spadeš na
        <select name="<?= $controller::SURFACE ?>">
            <?php foreach ($controller->getSurfaces() as $surface) { ?>
              <option value="<?= $surface->getValue() ?>"
                      <?php if ($controller->isSurfaceSelected($surface)) { ?>selected<?php } ?>>
                  <?= "{$surface->translateTo('cs')} ({$controller->getWoundsModifierBySurface($surface)->getValue()} ZZ)" ?></option>
            <?php } ?>
        </select>
      </label>
    </div>
    <div>
      <label>
        <input name="<?= $controller::HEAD ?>" value="1" type="checkbox"
               <?php if ($controller->isHitToHead()) { ?>checked="checked" <?php } ?>>
        padáš na hlavu <span class="hint">(+2 ZZ)</span>
      </label>
    </div>
    <div>
      <label>tvoje váha
        <input name="<?= $controller::BODY_WEIGHT ?>" type="number" placeholder="váha v kg" class="few-numbers"
               min="0" max="250"
               required
               value="<?= $controller->getSelectedBodyWeight() ? $controller->getSelectedBodyWeight()->getValue() : '' ?>">
        kg
      </label>
    </div>
    <div>
      <label title="třeba poník váží 240 kg, válečný kůň 700 kg, slon 6 tun, ale nespadnou na tebe celí">váha
        věcí, které spadly na tebe <span class="hint">(zbroj nepočítej)</span>
        <input name="<?= $controller::ITEMS_WEIGHT ?>" type="number" placeholder="váha v kg" class="few-numbers"
               min="0" max="10000"
               value="<?= $controller->getSelectedItemsWeight() ? $controller->getSelectedItemsWeight()->getValue() : '' ?>">
        kg
      </label>
    </div>
    <div><input type="submit" value="Přepočítat"></div>
  </div>
</div>