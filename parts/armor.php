<?php
namespace DrdPlus\Fight;
/** @var Controller $controller */
?>
<div class="block"><h2 id="Zbroj"><a href="#Zbroj" class="inner">Zbroj</a></h2></div>
<div class="block">
    <div class="panel">
        <label><select name="<?= $controller::BODY_ARMOR ?>">
                <?php foreach ($controller->getPossibleBodyArmors() as $bodyArmor) { ?>
                    <option value="<?= $bodyArmor->getValue() ?>"
                            <?php if ($controller->getSelectedBodyArmor()->getValue() === $bodyArmor->getValue()){ ?>selected<?php } ?>>
                        <?= $bodyArmor->translateTo('cs') . ' ' . ($controller->getProtectionOfBodyArmor($bodyArmor) > 0 ? ('+' . $controller->getProtectionOfBodyArmor($bodyArmor)) : '') ?>
                    </option>
                <?php } ?>
            </select>
        </label>
    </div>
    <div class="panel">
        <label>
            <select name="<?= $controller::HELM ?>">
                <?php foreach ($controller->getPossibleHelms() as $helm) { ?>
                    <option value="<?= $helm->getValue() ?>"
                            <?php if ($controller->getSelectedHelm()->getValue() === $helm->getValue()){ ?>selected<?php } ?>>
                        <?= $helm->translateTo('cs') . ' ' . ($controller->getProtectionOfHelm($helm) > 0 ? ('+' . $controller->getProtectionOfHelm($helm)) : '') ?>
                    </option>
                <?php } ?>
            </select>
        </label>
    </div>
</div>
<div class="block hint">(navrhne snížení zranění podle ochrany zbroje)</div>
<div class="block"><input type="submit" value="Přepočítat"></div>
