<?php
use DrdPlus\Codes\Transport\RidingAnimalCode;

/** @var \DrdPlus\Calculators\Fall\FallWebPartsContainer $webPartsContainer */
$currentFallValues = $webPartsContainer->getCurrentFallValues();
?>
<div class="row">
  <h2 id="pad" class="col"><a href="#pad">Pád</a></h2>
</div>
<div class="row">
  <div class="col-6">
    <label>
      <input id="onHorseback" type="radio" value="<?= $currentFallValues::HORSEBACK ?>"
             name="<?= $currentFallValues::FALLING_FROM ?>"
             required
             <?php if ($currentFallValues->isFallingFromHorseback()) { ?>checked="checked" <?php } ?>>
      <strong>padáš z "koně"</strong>
    </label>
    <label>
      <select class="horse-related" name="<?= $currentFallValues::HORSE_HEIGHT ?>">
          <?php /**
           * @var float $heightInMeters
           * @var RidingAnimalCode $ridingAnimal
           */
          foreach ($currentFallValues->getRidingAnimalsWithHeight() as $heightInMeters => $ridingAnimal) { ?>
            <option value="<?= $heightInMeters ?>"
                    <?php if ($currentFallValues->isRidingAnimalSelected($heightInMeters)) { ?>selected="selected"<?php } ?>>
                <?= "{$ridingAnimal} ({$heightInMeters} m)" ?>
            </option>
          <?php } ?>
      </select>
    </label>
  </div>
  <div class="col">
    <label>
      při jeho skoku
      <input type="checkbox" class="horse-related"
             name="<?= $currentFallValues::HORSE_IS_JUMPING ?>"
             <?php if ($currentFallValues->isHorseJumping()) { ?>checked="checked"<?php } ?>>
    </label>
  </div>
  <div class="col">
    <label>
      pohyb koně
      <select name="<?= $currentFallValues::RIDING_MOVEMENT ?>" class="horse-related">
          <?php foreach ($currentFallValues->getRidingAnimalMovements() as $ridingAnimalMovement) { ?>
            <option value="<?= $ridingAnimalMovement->getValue() ?>"
                    <?php if ($currentFallValues->isRidingAnimalMovementSelected($ridingAnimalMovement)) { ?>selected<?php } ?>>
                <?= $ridingAnimalMovement->translateTo('cs') . " (+{$currentFallValues->getBaseOfWoundsModifierByMovement($ridingAnimalMovement, false)} ZZ)" ?>
            </option>
          <?php } ?>
      </select>
    </label>
  </div>
</div>
<div class="row">
  <div class="col">
    <div>
      <label>
        <input type="radio" value="<?= $currentFallValues::HEIGHT ?>" id="fallingFromHeight"
               name="<?= $currentFallValues::FALLING_FROM ?>" required
               <?php if ($currentFallValues->isFallingFromHeight()) { ?>checked="checked" <?php } ?>>
        <strong>padáš z výšky</strong>
      </label>
      <label>
        <input type="number" name="<?= $currentFallValues::HEIGHT_OF_FALL ?>" class="few-numbers height-related" min="0" max="999"
               value="<?= $currentFallValues->getSelectedHeightOfFall()->getValue() ?>" placeholder="v metrech">
        metrů
      </label>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-6">
    <label>spadeš na
      <select name="<?= $currentFallValues::SURFACE ?>">
          <?php foreach ($currentFallValues->getSurfaces() as $surface) { ?>
            <option value="<?= $surface->getValue() ?>"
                    <?php if ($currentFallValues->isSurfaceSelected($surface)) { ?>selected<?php } ?>>
                <?= "{$surface->translateTo('cs')} ({$currentFallValues->getWoundsModifierBySurface($surface)->getValue()} ZZ)" ?></option>
          <?php } ?>
      </select>
    </label>
  </div>
  <div class="col">
    <label>
      <input name="<?= $currentFallValues::HEAD ?>" value="1" type="checkbox"
             <?php if ($currentFallValues->isHitToHead()) { ?>checked="checked" <?php } ?>>
      padáš na hlavu <span class="hint">(+2 ZZ)</span>
    </label>
  </div>
</div>
<div class="row">
  <div class="col">
    <label>tvoje váha v kg
      <input name="<?= $currentFallValues::BODY_WEIGHT ?>" type="number" placeholder="váha v kg" class="few-numbers"
             min="0" max="250"
             required
             value="<?= $currentFallValues->getCurrentWeightOfBody() ? $currentFallValues->getCurrentWeightOfBody()->getValue() : '80' ?>">
    </label>
  </div>
  <div class="col">
    <label title="třeba poník váží 240 kg, válečný kůň 700 kg, slon 6 tun, ale nespadnou na tebe celí">váha
      věcí v kg, které spadly na tebe
      <input name="<?= $currentFallValues::ITEMS_WEIGHT ?>" type="number" placeholder="váha v kg" class="few-numbers"
             min="0" max="10000"
             value="<?= $currentFallValues->getSelectedItemsWeight() ? $currentFallValues->getSelectedItemsWeight()->getValue() : '0' ?>">
    </label>
    <div class="hint">(zbroj nepočítej)</div>
  </div>
  <div><input type="submit" value="Přepočítat"></div>
</div>