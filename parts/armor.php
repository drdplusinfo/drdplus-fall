<?php
namespace DrdPlus\Fight;
/** @var Controller $controller */
?>
<div class="block">
    <h2 id="zbroj"><a href="#zbroj" class="inner">Zbroj</a></h2>
</div>
<div class="block">
    <div class="block">
        <label><select name="<?= $controller::BODY_ARMOR ?>">
                <?php foreach ($controller->getPossibleBodyArmors() as $bodyArmor) { ?>
                    <option value="<?= $bodyArmor->getValue() ?>"
                            <?php if ($controller->isBodyArmorSelected($bodyArmor)){ ?>selected<?php } ?>>
                        <?= $bodyArmor->translateTo('cs') . ' ' . ($controller->getProtectionOfBodyArmor($bodyArmor) > 0 ? ('+' . $controller->getProtectionOfBodyArmor($bodyArmor)) : '') ?>
                    </option>
                <?php } ?>
            </select>
            <span class="hint">(může snížit zranění podle povrchu)</span>
        </label>
    </div>
    <div class="block">
        <label>
            <select name="<?= $controller::HELM ?>">
                <?php foreach ($controller->getPossibleHelms() as $helm) { ?>
                    <option value="<?= $helm->getValue() ?>"
                            <?php if ($controller->isHelmSelected($helm)){ ?>selected<?php } ?>>
                        <?= $helm->translateTo('cs') . ' ' . ($controller->getProtectionOfHelm($helm) > 0 ? ('+' . $controller->getProtectionOfHelm($helm)) : '') ?>
                    </option>
                <?php } ?>
            </select>
            <span class="hint">(přičítá se ke zbroji)</span>
        </label>
    </div>
</div>
<div class="block"><input type="submit" value="Přepočítat"></div>
