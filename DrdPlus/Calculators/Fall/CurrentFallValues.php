<?php
declare(strict_types=1);

namespace DrdPlus\Calculators\Fall;

use DrdPlus\Background\BackgroundParts\Ancestry;
use DrdPlus\Background\BackgroundParts\SkillPointsFromBackground;
use DrdPlus\CalculatorSkeleton\CurrentValues;
use DrdPlus\Codes\Armaments\BodyArmorCode;
use DrdPlus\Codes\Armaments\HelmCode;
use DrdPlus\Codes\Environment\LandingSurfaceCode;
use DrdPlus\Codes\Transport\RidingAnimalCode;
use DrdPlus\Codes\Transport\RidingAnimalMovementCode;
use DrdPlus\Codes\Units\DistanceUnitCode;
use DrdPlus\Person\ProfessionLevels\ProfessionFirstLevel;
use DrdPlus\Professions\Commoner;
use DrdPlus\Properties\Base\Agility;
use DrdPlus\Properties\Body\BodyWeight;
use DrdPlus\Skills\Physical\Athletics;
use DrdPlus\Skills\Physical\PhysicalSkillPoint;
use DrdPlus\Tables\Measurements\Distance\Distance;
use DrdPlus\Tables\Measurements\Weight\Weight;
use DrdPlus\Tables\Measurements\Wounds\WoundsBonus;
use DrdPlus\Tables\Tables;
use Granam\DiceRolls\Templates\DiceRolls\Dice1d6Roll;
use Granam\DiceRolls\Templates\Rolls\Roll1d6;
use Granam\Integer\IntegerWithHistory;
use Granam\Integer\PositiveIntegerObject;
use Granam\Strict\Object\StrictObject;

class CurrentFallValues extends StrictObject
{

    public const AGILITY = 'agility';
    public const WITHOUT_REACTION = 'without_reaction';
    public const ATHLETICS = 'athletics';
    public const BAD_LUCK = 'bad_luck';
    public const BODY_ARMOR = 'body_armor';
    public const HELM = 'helm';
    public const FALLING_FROM = 'falling_from';
    public const HORSEBACK = 'horseback';
    public const HEIGHT = 'height';
    public const HEIGHT_OF_FALL = 'height_of_fall';
    public const RIDING_MOVEMENT = 'riding_movement';
    public const HORSE_HEIGHT = 'horse_height';
    public const JUMPING = 'jumping';
    public const SURFACE = 'surface';
    public const BODY_WEIGHT = 'body_weight';
    public const ITEMS_WEIGHT = 'items_weight';
    public const JUMP_IS_CONTROLLED = 'jump_is_controlled';
    public const HORSE_IS_JUMPING = 'horse_is_jumping';
    public const HEAD = 'head';

    private $currentValues;

    public function __construct(CurrentValues $currentValues)
    {
        $this->currentValues = $currentValues;
    }

    /**
     * @return array|BodyArmorCode[]
     */
    public function getPossibleBodyArmors(): array
    {
        return array_map(
            function (string $armorValue) {
                return BodyArmorCode::getIt($armorValue);
            },
            BodyArmorCode::getPossibleValues()
        );
    }

    public function isBodyArmorSelected(BodyArmorCode $bodyArmorCode): bool
    {
        return $this->getCurrentBodyArmorCode()->getValue() === $bodyArmorCode->getValue();
    }

    private function getCurrentBodyArmorCode(): BodyArmorCode
    {
        return BodyArmorCode::getIt(
            $this->currentValues->getCurrentValue(self::BODY_ARMOR)
            ?? BodyArmorCode::WITHOUT_ARMOR
        );
    }

    public function getSelectedAgility(): Agility
    {
        $selectedAgility = $this->currentValues->getCurrentValue(self::AGILITY);
        if ($selectedAgility === null) {
            return Agility::getIt(0);
        }

        return Agility::getIt($selectedAgility);
    }

    private function getSelectedAgilityWithReaction(): Agility
    {
        if ($this->isWithoutReaction()) {
            return Agility::getIt(-6);
        }

        return $this->getSelectedAgility();
    }

    public function isWithoutReaction(): bool
    {
        return (bool)$this->currentValues->getCurrentValue(self::WITHOUT_REACTION);
    }

    public function getSelectedAthletics(): Athletics
    {
        $athleticsValue = $this->currentValues->getCurrentValue(self::ATHLETICS);
        if ($athleticsValue === null) {
            return new Athletics(ProfessionFirstLevel::createFirstLevel(Commoner::getIt()));
        }
        $athletics = new Athletics(ProfessionFirstLevel::createFirstLevel(Commoner::getIt()));
        for ($athleticsRank = 1; $athleticsRank <= $athleticsValue; $athleticsRank++) {
            $athletics->increaseSkillRank(PhysicalSkillPoint::createFromFirstLevelSkillPointsFromBackground(
                ProfessionFirstLevel::createFirstLevel(Commoner::getIt()),
                SkillPointsFromBackground::getIt(
                    new PositiveIntegerObject(8),
                    Ancestry::getIt(new PositiveIntegerObject(8), Tables::getIt()),
                    Tables::getIt()
                ),
                Tables::getIt()
            ));
        }

        return $athletics;
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
        return $this->getCurrentHelmCode()->getValue() === $helmCode->getValue();
    }

    private function getCurrentHelmCode(): HelmCode
    {
        return HelmCode::getIt(
            $this->currentValues->getCurrentValue(self::HELM)
            ?? HelmCode::WITHOUT_HELM
        );
    }

    public function isFallingFromHorseback(): bool
    {
        return $this->currentValues->getCurrentValue(self::FALLING_FROM) === self::HORSEBACK;
    }

    public function isFallingFromHeight(): bool
    {
        return $this->currentValues->getCurrentValue(self::FALLING_FROM) === self::HEIGHT
            || !$this->isFallingFromHorseback(); // as falling from height is default
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
                    $perHeight['3.1'][] = RidingAnimalCode::getIt($ridingAnimalName);
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
        return (float)$this->currentValues->getCurrentValue(self::HORSE_HEIGHT) === $heightInMeters;
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
        return $this->currentValues->getCurrentValue(self::RIDING_MOVEMENT) === $ridingAnimalMovementCode->getValue();
    }

    public function getBaseOfWoundsModifierByMovement(
        RidingAnimalMovementCode $ridingAnimalMovementCode,
        bool $horseIsJumping
    ): int
    {
        return Tables::getIt()->getWoundsOnFallFromHorseTable()
            ->getWoundsAdditionOnFallFromHorse(
                $ridingAnimalMovementCode,
                $horseIsJumping,
                Tables::getIt()->getWoundsTable()
            )->getValue();
    }

    public function getProtectionOfBodyArmor(BodyArmorCode $bodyArmorCode): int
    {
        return Tables::getIt()->getBodyArmorsTable()->getProtectionOf($bodyArmorCode);
    }

    public function getProtectionOfHelm(HelmCode $helmCode): int
    {
        return Tables::getIt()->getHelmsTable()->getProtectionOf($helmCode);
    }

    /**
     * @return array|LandingSurfaceCode[]
     */
    public function getSurfaces(): array
    {
        return array_map(function (string $surface) {
            return LandingSurfaceCode::getIt($surface);
        }, LandingSurfaceCode::getPossibleValues());
    }

    public function isSurfaceSelected(LandingSurfaceCode $landingSurfaceCode): bool
    {
        return $this->getSelectedLandingSurface()->getValue() === $landingSurfaceCode->getValue();
    }

    /**
     * Also agility is taken into account (for water).
     *
     * @param LandingSurfaceCode $landingSurfaceCode
     * @return IntegerWithHistory
     */
    public function getWoundsModifierBySurface(LandingSurfaceCode $landingSurfaceCode): IntegerWithHistory
    {
        return Tables::getIt()->getLandingSurfacesTable()->getBaseOfWoundsModifier(
            $landingSurfaceCode,
            $this->getSelectedAgilityWithReaction(),
            new PositiveIntegerObject($this->getProtectionOfBodyArmor($this->getSelectedBodyArmor()))
        );
    }

    private function getSelectedBodyArmor(): BodyArmorCode
    {
        $bodyArmor = $this->currentValues->getCurrentValue(self::BODY_ARMOR);
        if ($bodyArmor) {
            return BodyArmorCode::getIt($bodyArmor);
        }

        return BodyArmorCode::getIt(BodyArmorCode::WITHOUT_ARMOR);
    }

    private function getSelectedHelm(): HelmCode
    {
        $bodyArmor = $this->currentValues->getCurrentValue(self::HELM);
        if ($bodyArmor) {
            return HelmCode::getIt($bodyArmor);
        }

        return HelmCode::getIt(HelmCode::WITHOUT_HELM);
    }

    public function getWoundsByFall(): ?int
    {
        if (!$this->isFallingFromHeight() && !$this->isFallingFromHorseback()) {
            return null;
        }
        if (!$this->getCurrentBodyWeight() || !$this->getCurrentBadLuck()) {
            return null;
        }
        $woundsFromFall = Tables::getIt()->getJumpsAndFallsTable()->getWoundsFromJumpOrFall(
            $this->isFallingFromHorseback()
                ? $this->getSelectedRidingAnimalHeight()
                : $this->getSelectedHeightOfFall(),
            BodyWeight::getIt($this->getCurrentBodyWeight()),
            $this->getSelectedItemsWeight(),
            $this->getCurrentBadLuck(),
            $this->isJumpControlled(),
            $this->getSelectedAgilityWithReaction(),
            $this->getSelectedAthletics(),
            $this->getSelectedLandingSurface(),
            new PositiveIntegerObject($this->getProtectionOfBodyArmor($this->getSelectedBodyArmor())),
            $this->isHitToHead(),
            new PositiveIntegerObject($this->getProtectionOfHelm($this->getSelectedHelm())),
            Tables::getIt()
        );
        if ($this->isFallingFromHorseback()) {
            $baseOfWoundsModifierByMovement = $this->getBaseOfWoundsModifierByMovement(
                $this->getSelectedRidingAnimalMovement(),
                $this->isHorseJumping()
            );
            if ($baseOfWoundsModifierByMovement !== 0) {
                $woundsFromFall = (new WoundsBonus(
                    $woundsFromFall->getBonus()->getValue() + $baseOfWoundsModifierByMovement,
                    Tables::getIt()->getWoundsTable()
                ))->getWounds();
            }
        }

        return $woundsFromFall->getValue();
    }

    private function getSelectedRidingAnimalHeight(): Distance
    {
        return new Distance(
            (float)$this->currentValues->getCurrentValue(self::HORSE_HEIGHT),
            DistanceUnitCode::METER,
            Tables::getIt()->getDistanceTable()
        );
    }

    public function getSelectedHeightOfFall(): Distance
    {
        $heightOfFall = $this->currentValues->getCurrentValue(self::HEIGHT_OF_FALL);
        if (!$heightOfFall) {
            return new Distance(0, DistanceUnitCode::METER, Tables::getIt()->getDistanceTable());
        }

        return new Distance($heightOfFall, DistanceUnitCode::METER, Tables::getIt()->getDistanceTable());
    }

    private function getSelectedRidingAnimalMovement(): RidingAnimalMovementCode
    {
        $selectedMovement = $this->currentValues->getCurrentValue(self::RIDING_MOVEMENT);
        if (!$selectedMovement) {
            return RidingAnimalMovementCode::getIt(RidingAnimalMovementCode::STILL);
        }

        return RidingAnimalMovementCode::getIt($selectedMovement);
    }

    public function getCurrentBodyWeight(): ?Weight
    {
        $weight = $this->currentValues->getCurrentValue(self::BODY_WEIGHT);
        if (!$weight) {
            return null;
        }

        return new Weight($weight, Weight::KG, Tables::getIt()->getWeightTable());
    }

    public function getSelectedItemsWeight(): ?Weight
    {
        $weight = $this->currentValues->getCurrentValue(self::ITEMS_WEIGHT);
        if (!$weight) {
            return null;
        }

        return new Weight($weight, Weight::KG, Tables::getIt()->getWeightTable());
    }

    public function getCurrentBadLuck(): Roll1d6
    {
        $roll = $this->currentValues->getCurrentValue(self::BAD_LUCK);
        if (!$roll) {
            return new Roll1d6(new Dice1d6Roll(1, 1));
        }

        return new Roll1d6(new Dice1d6Roll($roll, 1));
    }

    public function isJumpControlled(): bool
    {
        return (bool)$this->currentValues->getCurrentValue(self::JUMP_IS_CONTROLLED);
    }

    public function isHorseJumping(): bool
    {
        return (bool)$this->currentValues->getCurrentValue(self::HORSE_IS_JUMPING);
    }

    public function getSelectedLandingSurface(): LandingSurfaceCode
    {
        $landingSurface = $this->currentValues->getCurrentValue(self::SURFACE);
        if (!$landingSurface) {
            return LandingSurfaceCode::getIt(LandingSurfaceCode::MEADOW);
        }

        return LandingSurfaceCode::getIt($landingSurface);
    }

    public function isHitToHead(): bool
    {
        return (bool)$this->currentValues->getCurrentValue(self::HEAD);
    }
}