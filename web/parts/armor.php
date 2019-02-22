<?php
/** @var \DrdPlus\Calculators\Fall\FallWebPartsContainer $webPartsContainer */
$currentFallValues = $webPartsContainer->getCurrentFallValues();
?>
<div class="row">
  <h2 id="zbroj" class="col"><a href="#zbroj" class="inner">Zbroj</a></h2>
</div>
<div class="row">
  <div class="col">
    <label><select name="<?= $currentFallValues::BODY_ARMOR ?>">
            <?php foreach ($currentFallValues->getPossibleBodyArmors() as $bodyArmor) { ?>
              <option value="<?= $bodyArmor->getValue() ?>"
                      <?php if ($currentFallValues->isBodyArmorSelected($bodyArmor)){ ?>selected<?php } ?>>
                  <?= $bodyArmor->translateTo('cs') . ' ' . ($currentFallValues->getProtectionOfBodyArmor($bodyArmor) > 0 ? ('+' . $currentFallValues->getProtectionOfBodyArmor($bodyArmor)) : '') ?>
              </option>
            <?php } ?>
      </select>
      <span class="hint">(chrání při dopadu na tvrdý či ostrý povrch)</span>
    </label>
  </div>
  <div class="col">
    <label>
      <select name="<?= $currentFallValues::HELM ?>">
          <?php foreach ($currentFallValues->getPossibleHelms() as $helm) { ?>
            <option value="<?= $helm->getValue() ?>"
                    <?php if ($currentFallValues->isHelmSelected($helm)){ ?>selected<?php } ?>>
                <?= $helm->translateTo('cs') . ' ' . ($currentFallValues->getProtectionOfHelm($helm) > 0 ? ('+' . $currentFallValues->getProtectionOfHelm($helm)) : '') ?>
            </option>
          <?php } ?>
      </select>
      <span class="hint">(chrání při zranění hlavy a tvrdém či ostrém povrchu)</span>
    </label>
  </div>
</div>
<div class="block"><input type="submit" value="Přepočítat"></div>
