<?php
/** @var \DrdPlus\Calculator\Fall\FallController $controller */
?>
<div class="row">
  <h2 id="zbroj" class="col"><a href="#zbroj" class="inner">Zbroj</a></h2>
</div>
<div class="row">
  <div class="col">
    <label><select name="<?= $controller::BODY_ARMOR ?>">
            <?php foreach ($controller->getPossibleBodyArmors() as $bodyArmor) { ?>
              <option value="<?= $bodyArmor->getValue() ?>"
                      <?php if ($controller->isBodyArmorSelected($bodyArmor)){ ?>selected<?php } ?>>
                  <?= $bodyArmor->translateTo('cs') . ' ' . ($controller->getProtectionOfBodyArmor($bodyArmor) > 0 ? ('+' . $controller->getProtectionOfBodyArmor($bodyArmor)) : '') ?>
              </option>
            <?php } ?>
      </select>
      <span class="hint">(může snížit zranění při dopadu na ostrý povrch)</span>
    </label>
  </div>
  <div class="col">
    <label>
      <select name="<?= $controller::HELM ?>">
          <?php foreach ($controller->getPossibleHelms() as $helm) { ?>
            <option value="<?= $helm->getValue() ?>"
                    <?php if ($controller->isHelmSelected($helm)){ ?>selected<?php } ?>>
                <?= $helm->translateTo('cs') . ' ' . ($controller->getProtectionOfHelm($helm) > 0 ? ('+' . $controller->getProtectionOfHelm($helm)) : '') ?>
            </option>
          <?php } ?>
      </select>
      <span class="hint">(při zranění hlavy)</span>
    </label>
  </div>
</div>
<div class="block"><input type="submit" value="Přepočítat"></div>
