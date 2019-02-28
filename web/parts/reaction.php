<?php
/** @var \DrdPlus\Calculators\Fall\FallWebPartsContainer $webPartsContainer */
$currentFallValues = $webPartsContainer->getCurrentFallValues();
?>
<div class="row">
  <h2 id="akce_a_reakce" class="col"><a href="#akce_a_reakce" class="inner">Akce a reakce</a></h2>
</div>
<div class="row">
  <div class="col">
    <label>
      <input type="checkbox" name="<?= $currentFallValues::JUMP_IS_CONTROLLED ?>"
             <?php if ($currentFallValues->isJumpControlled()) { ?>checked="checked" <?php } ?>>
      skočils
    </label>
    <div class="hint">(pád tě nepřekvapil => výška -2 metry)</div>
  </div>
  <div class="col">
    <label>
      <input id="withoutReaction" type="checkbox" name="<?= $currentFallValues::WITHOUT_REACTION ?>" value="1"
             <?php if ($currentFallValues->isWithoutReaction()) { ?>checked="checked"<?php } ?>>
      neovládáš tělo
    </label>
    <div class="hint">(výsledná obratnost -6)</div>
  </div>
</div>
<div class="row">
  <div class="col">
    <label>
      obratnost
      <input id="agility" type="number" class="single-number" name="<?= $currentFallValues::AGILITY ?>" min="-40" max="40"
             required value="<?= $currentFallValues->getSelectedAgility()->getValue() ?>">
    </label>
  </div>
  <div class="col">
    <label>smůla <span class="hint">(1k6)</span>
      <select name="<?= $currentFallValues::BAD_LUCK ?>">
          <?php foreach (range(1, 6) as $roll) { ?>
            <option value="<?= $roll ?>"
                <?php if ($currentFallValues->getCurrentBadLuck()->getValue() === $roll) { ?>
                  selected
                <?php } ?>>
                <?= $roll ?>
            </option>
          <?php } ?>
      </select>
    </label>
  </div>
  <div class="col">
    <label>atletika
      <select name="<?= $currentFallValues::ATHLETICS ?>">
          <?php foreach (['-', 'I', 'II', 'III'] as $rankValue => $rankName) { ?>
            <option value="<?= $rankValue ?>"
                <?php if ($currentFallValues->getSelectedAthletics()->getCurrentSkillRank()->getValue() === $rankValue) { ?>
                  selected
                <?php } ?>>
                <?= $rankName ?>
            </option>
          <?php } ?>
      </select>
    </label>
  </div>
</div>
<div><input type="submit" value="Přepočítat"></div>
