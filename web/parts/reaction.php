<?php
/** @var \DrdPlus\Calculators\Fall\CurrentFallValues $currentFallValues */
?>
<div class="row">
  <h2 id="akce_a_reakce" class="col"><a href="#akce_a_reakce" class="inner">Akce a reakce</a></h2>
</div>
<div class="row">
  <div class="col">
    <div>
      <div>
        <label>
          <input type="checkbox" name="<?= $currentFallValues::JUMP_IS_CONTROLLED ?>"
                 <?php if ($currentFallValues->isJumpControlled()) { ?>checked="checked" <?php } ?>>
          skočils <span class="hint">(pád tě nepřekvapil => výška -2 metry)</span>
        </label>
      </div>
    </div>
    <div>
      <div>
        <label>
          <input id="withoutReaction" type="checkbox" name="<?= $currentFallValues::WITHOUT_REACTION ?>" value="1"
                 <?php if ($currentFallValues->isWithoutReaction()) { ?>checked="checked"<?php } ?>>
          neovládáš tělo <span class="hint">(výsledná obratnost -6)</span>
        </label>
      </div>
    </div>
    <div>
      <div>
        <label>
          obratnost
          <input id="agility" type="number" class="single-number" name="<?= $currentFallValues::AGILITY ?>" min="-40" max="40"
                 required value="<?= $currentFallValues->getSelectedAgility()->getValue() ?>">
        </label>
      </div>
    </div>
    <div>
      <div>
        <label>smůla
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
          <span class="hint">(1k6)</span>
        </label>
      </div>
    </div>
    <div>
      <div>
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
  </div>
</div>
<div><input type="submit" value="Přepočítat"></div>
