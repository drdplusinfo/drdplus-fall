<?php
namespace DrdPlus\Fight;

use DrdPlus\Codes\Armaments\BodyArmorCode;
use DrdPlus\Codes\Armaments\HelmCode;
use DrdPlus\Codes\Properties\PropertyCode;
use DrdPlus\Codes\Transport\RidingAnimalCode;
use DrdPlus\Codes\Transport\RidingAnimalMovementCode;
use DrdPlus\Properties\Base\Agility;
use DrdPlus\Tables\Tables;

class Controller extends \DrdPlus\Configurator\Skeleton\Controller
{
    const AGILITY = PropertyCode::AGILITY;
    const BODY_ARMOR = 'body_armor';
    const HELM = 'helm';
    const FALLING_FROM = 'falling_from';
    const FALLING_FROM_HORSEBACK = 'falling_from_horseback';
    const FALLING_FROM_HEIGHT = 'falling_from_height';
    const HEIGHT_OF_FALL = 'height_of_fall';
    const RIDING_MOVEMENT = 'riding_movement';
    const RIDING_ANIMAL_HEIGHT = 'riding_animal_height';
    const JUMPING = 'jumping';

    public function __construct()
    {
        parent::__construct('fight' /* cookies postfix */);
    }

    /**
     * @return array|BodyArmorCode[]
     */
    public function getPossibleBodyArmors(): array
    {
        return array_map(function (string $armorValue) {
            return BodyArmorCode::getIt($armorValue);
        }, BodyArmorCode::getPossibleValues());
    }

    public function isBodyArmorSelected(BodyArmorCode $bodyArmorCode): bool
    {
        return $this->getHistory()->getValue(self::BODY_ARMOR) === $bodyArmorCode->getValue();
    }

    public function getSelectedAgility(): Agility
    {
        $selectedAgility = $this->getHistory()->getValue(self::AGILITY);
        if ($selectedAgility === null) {
            return Agility::getIt(0);
        }

        return Agility::getIt($selectedAgility);
    }

    /**
     * @return array|HelmCode[]
     */
    public function getPossibleHelms(): array
    {
        return array_map(function (string $helmValue) {
            return HelmCode::getIt($helmValue);
        }, HelmCode::getPossibleValues());
    }

    public function isHelmSelected(HelmCode $helmCode): bool
    {
        return $this->getHistory()->getValue(self::HELM) === $helmCode->getValue();
    }

    public function isFallingFromHorseback(): bool
    {
        return (bool)$this->getHistory()->getValue(self::FALLING_FROM_HORSEBACK);
    }

    public function isFallingFromHeight(): bool
    {
        return (bool)$this->getHistory()->getValue(self::FALLING_FROM_HEIGHT);
    }

    public function getRidingAnimalsWithHeight(): array
    {
        $perHeight = [];
        foreach (RidingAnimalCode::getPossibleValues() as $ridingAnimalName) {
            switch ($ridingAnimalName) {
                case RidingAnimalCode::DONKEY :
                case RidingAnimalCode::MULE :
                case RidingAnimalCode::HINNY :
                case RidingAnimalCode::PONY :
                    $perHeight['1.1'][] = RidingAnimalCode::getIt($ridingAnimalName);
                    break;
                case RidingAnimalCode::YAK :
                case RidingAnimalCode::LAME :
                    $perHeight['1.3'][] = RidingAnimalCode::getIt($ridingAnimalName);
                    break;
                case RidingAnimalCode::COW :
                case RidingAnimalCode::BULL :
                    $perHeight['1.5'][] = RidingAnimalCode::getIt($ridingAnimalName);
                    break;
                case RidingAnimalCode::CAMEL :
                case RidingAnimalCode::HORSE :
                case RidingAnimalCode::DRAFT_HORSE :
                case RidingAnimalCode::UNICORN :
                    $perHeight['1.7'][] = RidingAnimalCode::getIt($ridingAnimalName);
                    break;
                case RidingAnimalCode::WAR_HORSE :
                    $perHeight['1.8'][] = RidingAnimalCode::getIt($ridingAnimalName);
                    break;
                case RidingAnimalCode::ELEPHANT :
                    $perHeight['3.5'][] = RidingAnimalCode::getIt($ridingAnimalName);
                    break;
            }
        }

        $withHeight = [];
        foreach ($perHeight as $height => $animalsWithSameHeight) {
            $localizedAnimalsWithSameHeight = array_map(function (RidingAnimalCode $ridingAnimalCode) {
                return $ridingAnimalCode->translateTo('cs');
            }, $animalsWithSameHeight);
            $withHeight[$height] = implode(', ', $localizedAnimalsWithSameHeight);
        }
        ksort($withHeight);

        return $withHeight;
    }

    public function isRidingAnimalSelected(float $heightInMeters): bool
    {
        return (float)$this->getValueFromRequest(self::RIDING_ANIMAL_HEIGHT) === $heightInMeters;
    }

    /**
     * @return array|RidingAnimalMovementCode[]
     */
    public function getRidingAnimalMovements(): array
    {
        return array_map(function (string $movement) {
            return RidingAnimalMovementCode::getIt($movement);
        }, RidingAnimalMovementCode::getPossibleValuesWithoutJumping());
    }

    public function isRidingAnimalMovementSelected(RidingAnimalMovementCode $ridingAnimalMovementCode): bool
    {
        return $this->getValueFromRequest(self::RIDING_MOVEMENT) === $ridingAnimalMovementCode->getValue();
    }

    public function isJumping(): bool
    {
        return (bool)$this->getValueFromRequest(self::JUMPING);
    }

    public function getProtectionOfBodyArmor(BodyArmorCode $bodyArmorCode): int
    {
        return Tables::getIt()->getBodyArmorsTable()->getProtectionOf($bodyArmorCode);
    }

    public function getProtectionOfSelectedBodyArmor(): int
    {
        return $this->getProtectionOfBodyArmor($this->getSelectedBodyArmor());
    }

    private function getSelectedBodyArmor(): BodyArmorCode
    {
        $selectedBodyArmor = $this->getHistory()->getValue(self::BODY_ARMOR);
        if (!$selectedBodyArmor) {
            return BodyArmorCode::getIt(BodyArmorCode::WITHOUT_ARMOR);
        }

        return BodyArmorCode::getIt($selectedBodyArmor);
    }

    public function getProtectionOfHelm(HelmCode $helmCode): int
    {
        return Tables::getIt()->getHelmsTable()->getProtectionOf($helmCode);
    }

    public function getProtectionOfSelectedHelm(): int
    {
        return $this->getProtectionOfHelm($this->getSelectedHelm());
    }

    private function getSelectedHelm(): HelmCode
    {
        $selectedHelm = $this->getHistory()->getValue(self::HELM);
        if (!$selectedHelm) {
            return HelmCode::getIt(HelmCode::WITHOUT_HELM);
        }

        return HelmCode::getIt($selectedHelm);
    }

}