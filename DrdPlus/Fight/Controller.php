<?php
namespace DrdPlus\Fight;

use DrdPlus\Codes\Armaments\BodyArmorCode;
use DrdPlus\Codes\Armaments\HelmCode;
use DrdPlus\Codes\Armaments\ShieldCode;
use DrdPlus\Codes\Armaments\WeaponCategoryCode;
use DrdPlus\Codes\Properties\PropertyCode;
use DrdPlus\Codes\Skills\CombinedSkillCode;
use DrdPlus\Codes\Skills\PhysicalSkillCode;
use DrdPlus\Codes\Skills\PsychicalSkillCode;
use DrdPlus\Codes\Skills\SkillCode;
use DrdPlus\Codes\Transport\RidingAnimalCode;
use DrdPlus\Configurator\Skeleton\History;
use DrdPlus\Tables\Tables;
use Granam\String\StringTools;

class Controller extends \DrdPlus\Configurator\Skeleton\Controller
{
    const MELEE_WEAPON = 'melee_weapon';
    const RANGED_WEAPON = 'ranged_weapon';
    const STRENGTH = PropertyCode::STRENGTH;
    const AGILITY = PropertyCode::AGILITY;
    const KNACK = PropertyCode::KNACK;
    const WILL = PropertyCode::WILL;
    const INTELLIGENCE = PropertyCode::INTELLIGENCE;
    const CHARISMA = PropertyCode::CHARISMA;
    const SIZE = PropertyCode::SIZE;
    const HEIGHT_IN_CM = PropertyCode::HEIGHT_IN_CM;
    const MELEE_WEAPON_HOLDING = 'melee_weapon_holding';
    const RANGED_WEAPON_HOLDING = 'ranged_weapon_holding';
    const PROFESSION = 'profession';
    const MELEE_FIGHT_SKILL = 'melee_fight_skill';
    const MELEE_FIGHT_SKILL_RANK = 'melee_fight_skill_rank';
    const RANGED_FIGHT_SKILL = 'ranged_fight_skill';
    const RANGED_FIGHT_SKILL_RANK = 'ranged_fight_skill_rank';
    const SHIELD = 'shield';
    const SHIELD_USAGE_SKILL_RANK = 'shield_usage_skill_rank';
    const FIGHT_WITH_SHIELDS_SKILL_RANK = 'fight_with_shields_skill_rank';
    const BODY_ARMOR = 'body_armor';
    const ARMOR_SKILL_VALUE = 'armor_skill_value';
    const HELM = 'helm';
    const ON_HORSEBACK = 'on_horseback';
    const RIDING_SKILL_RANK = 'riding_skill_rank';
    const FIGHT_FREE_WILL_ANIMAL = 'fight_free_will_animal';
    const ZOOLOGY_SKILL_RANK = 'zoology_skill_rank';
    const SCROLL_FROM_TOP = 'scroll_from_top';

    /** @var CurrentValues */
    private $currentValues;
    /** @var PreviousValues */
    private $previousValues;

    public function __construct()
    {
        parent::__construct('fight' /* cookies postfix */);
        $this->currentValues = new CurrentValues($_GET, $this->getHistoryWithSkillRanks());
        $this->previousValues = new PreviousValues($_GET);
    }

    protected function createHistory(string $cookiesPostfix, int $cookiesTtl = null): History
    {
        return new HistoryWithSkillRanks(
            [
                self::MELEE_FIGHT_SKILL => self::MELEE_FIGHT_SKILL_RANK,
                self::RANGED_FIGHT_SKILL => self::RANGED_FIGHT_SKILL_RANK,
                self::RANGED_FIGHT_SKILL => self::RANGED_FIGHT_SKILL_RANK,
            ],
            !empty($_POST[self::DELETE_HISTORY]), // clear history?
            $_GET, // values to remember
            !empty($_GET[self::REMEMBER_HISTORY]), // should remember given values
            $cookiesPostfix,
            $cookiesTtl
        );
    }

    private function getHistoryWithSkillRanks(): HistoryWithSkillRanks
    {
        return $this->getHistory();
    }

    public function getSelectedScrollFromTop(): int
    {
        return (int)$this->currentValues->getValue(self::SCROLL_FROM_TOP);
    }

    /**
     * @param array|string $weaponCategoryValues
     * @return array|SkillCode[]
     */
    private function getPossibleSkillsForCategories(array $weaponCategoryValues): array
    {
        $fightWithCategories = [];
        $fightWithPhysical = array_map(
            function (string $skillName) {
                return PhysicalSkillCode::getIt($skillName);
            },
            $this->filterForCategories(PhysicalSkillCode::getPossibleValues(), $weaponCategoryValues)
        );
        $fightWithCategories = array_merge($fightWithCategories, $fightWithPhysical);
        $fightWithPsychical = array_map(
            function (string $skillName) {
                return PsychicalSkillCode::getIt($skillName);
            },
            $this->filterForCategories(PsychicalSkillCode::getPossibleValues(), $weaponCategoryValues)
        );
        $fightWithCategories = array_merge($fightWithCategories, $fightWithPsychical);
        $fightWithCombined = array_map(
            function (string $skillName) {
                return CombinedSkillCode::getIt($skillName);
            },
            $this->filterForCategories(CombinedSkillCode::getPossibleValues(), $weaponCategoryValues)
        );
        $fightWithCategories = array_merge($fightWithCategories, $fightWithCombined);

        return $fightWithCategories;
    }

    private function filterForCategories(array $skillCodeValues, array $weaponCategoryValues): array
    {
        $fightWith = array_filter(
            $skillCodeValues,
            function (string $skillName) {
                return strpos($skillName, 'fight_') === 0;
            }
        );
        $categoryNames = array_map(
            function (string $categoryName) {
                return StringTools::toConstant(WeaponCategoryCode::getIt($categoryName)->translateTo('en', 4));
            },
            $weaponCategoryValues
        );

        return array_filter($fightWith, function (string $skillName) use ($categoryNames) {
            $categoryFromSkill = str_replace(['fight_with_', 'fight_' /*without weapon */], '', $skillName);

            return in_array($categoryFromSkill, $categoryNames, true);
        });
    }

    /**
     * @return array|SkillCode[]
     */
    public function getPossibleSkillsForRanged(): array
    {
        return $this->getPossibleSkillsForCategories(WeaponCategoryCode::getRangedWeaponCategoryValues());
    }

    public function getSelectedMeleeSkillCode(): SkillCode
    {
        return $this->getSelectedSkill($this->currentValues->getValue(self::MELEE_FIGHT_SKILL));
    }

    private function getSelectedSkill($skillName): SkillCode
    {
        if (!$skillName) {
            return PhysicalSkillCode::getIt(PhysicalSkillCode::FIGHT_UNARMED);
        }

        if (in_array($skillName, PhysicalSkillCode::getPossibleValues(), true)) {
            return PhysicalSkillCode::getIt($skillName);
        }

        if (in_array($skillName, PsychicalSkillCode::getPossibleValues(), true)) {
            return PsychicalSkillCode::getIt($skillName);
        }
        if (in_array($skillName, CombinedSkillCode::getPossibleValues(), true)) {
            return CombinedSkillCode::getIt($skillName);
        }

        throw new \LogicException('Unexpected skill value ' . var_export($skillName, true));
    }

    public function getPreviousMeleeSkillCode(): SkillCode
    {
        return $this->getSelectedSkill($this->previousValues->getValue(self::MELEE_FIGHT_SKILL));
    }

    public function getSelectedRangedSkillCode(): SkillCode
    {
        return $this->getSelectedSkill($this->currentValues->getValue(self::RANGED_FIGHT_SKILL));
    }

    public function getPreviousRangedSkillCode(): SkillCode
    {
        return $this->getSelectedSkill($this->previousValues->getValue(self::RANGED_FIGHT_SKILL));
    }

    public function getSelectedMeleeSkillRank(): int
    {
        return (int)$this->currentValues->getValue(self::MELEE_FIGHT_SKILL_RANK);
    }

    public function getPreviousMeleeSkillRank(): int
    {
        return (int)$this->previousValues->getValue(self::MELEE_FIGHT_SKILL_RANK);
    }

    public function getHistoryMeleeSkillRanksJson(): string
    {
        return $this->arrayToJson($this->getHistoryWithSkillRanks()->getPreviousSkillRanks(self::MELEE_FIGHT_SKILL_RANK));
    }

    private function arrayToJson(array $values): string
    {
        return json_encode($values, JSON_PRETTY_PRINT | JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE);
    }

    public function getHistoryRangedSkillRanksJson(): string
    {
        return $this->arrayToJson($this->getHistoryWithSkillRanks()->getPreviousSkillRanks(self::RANGED_FIGHT_SKILL_RANK));
    }

    public function getSelectedRangedSkillRank(): int
    {
        return (int)$this->currentValues->getValue(self::RANGED_FIGHT_SKILL_RANK);
    }

    public function getPreviousRangedSkillRank(): int
    {
        return (int)$this->previousValues->getValue(self::RANGED_FIGHT_SKILL_RANK);
    }

    /**
     * @return array|ShieldCode[]
     */
    public function getPossibleShields(): array
    {
        return array_map(function (string $armorValue) {
            return ShieldCode::getIt($armorValue);
        }, ShieldCode::getPossibleValues());
    }

    public function getSelectedShield(): ShieldCode
    {
        $shield = $this->currentValues->getValue(self::SHIELD);
        if (!$shield) {
            return ShieldCode::getIt(ShieldCode::WITHOUT_SHIELD);
        }

        return ShieldCode::getIt($shield);
    }

    public function getPreviousShield(): ShieldCode
    {
        $shield = $this->previousValues->getValue(self::SHIELD);
        if (!$shield) {
            return $this->getSelectedShield();
        }

        return ShieldCode::getIt($shield);
    }

    /**
     * @return PhysicalSkillCode
     */
    public function getShieldUsageSkillCode(): PhysicalSkillCode
    {
        return PhysicalSkillCode::getIt(PhysicalSkillCode::SHIELD_USAGE);
    }

    public function getSelectedShieldUsageSkillRank(): int
    {
        return (int)$this->currentValues->getValue(self::SHIELD_USAGE_SKILL_RANK);
    }

    public function getPreviousShieldUsageSkillRank(): int
    {
        return (int)$this->previousValues->getValue(self::SHIELD_USAGE_SKILL_RANK);
    }

    /**
     * @return PhysicalSkillCode
     */
    public function getFightWithShieldsSkillCode(): PhysicalSkillCode
    {
        return PhysicalSkillCode::getIt(PhysicalSkillCode::FIGHT_WITH_SHIELDS);
    }

    public function getSelectedFightWithShieldsSkillRank(): int
    {
        return (int)$this->currentValues->getValue(self::FIGHT_WITH_SHIELDS_SKILL_RANK);
    }

    public function getPreviousFightWithShieldsSkillRank(): int
    {
        return (int)$this->previousValues->getValue(self::FIGHT_WITH_SHIELDS_SKILL_RANK);
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

    public function getSelectedBodyArmor(): BodyArmorCode
    {
        $shield = $this->currentValues->getValue(self::BODY_ARMOR);
        if (!$shield) {
            return BodyArmorCode::getIt(BodyArmorCode::WITHOUT_ARMOR);
        }

        return BodyArmorCode::getIt($shield);
    }

    public function getProtectionOfBodyArmor(BodyArmorCode $bodyArmorCode): int
    {
        return Tables::getIt()->getBodyArmorsTable()->getProtectionOf($bodyArmorCode);
    }

    public function getProtectionOfSelectedBodyArmor(): int
    {
        return $this->getProtectionOfBodyArmor($this->getSelectedBodyArmor());
    }

    public function getProtectionOfPreviousBodyArmor(): int
    {
        return Tables::getIt()->getBodyArmorsTable()->getProtectionOf($this->getPreviousBodyArmor());
    }

    public function getPreviousBodyArmor(): BodyArmorCode
    {
        $shield = $this->previousValues->getValue(self::BODY_ARMOR);
        if (!$shield) {
            return BodyArmorCode::getIt(BodyArmorCode::WITHOUT_ARMOR);
        }

        return BodyArmorCode::getIt($shield);
    }

    public function getSelectedArmorSkillRank(): int
    {
        return (int)$this->currentValues->getValue(self::ARMOR_SKILL_VALUE);
    }

    public function getPreviousArmorSkillRank(): int
    {
        return (int)$this->previousValues->getValue(self::ARMOR_SKILL_VALUE);
    }

    /**
     * @return PhysicalSkillCode
     */
    public function getPossibleSkillForArmor(): PhysicalSkillCode
    {
        return PhysicalSkillCode::getIt(PhysicalSkillCode::ARMOR_WEARING);
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

    public function getSelectedHelm(): HelmCode
    {
        $shield = $this->currentValues->getValue(self::HELM);
        if (!$shield) {
            return HelmCode::getIt(HelmCode::WITHOUT_HELM);
        }

        return HelmCode::getIt($shield);
    }

    public function getProtectionOfHelm(HelmCode $helmCode): int
    {
        return Tables::getIt()->getHelmsTable()->getProtectionOf($helmCode);
    }

    public function getProtectionOfSelectedHelm(): int
    {
        return $this->getProtectionOfHelm($this->getSelectedHelm());
    }

    public function getSelectedOnHorseback(): bool
    {
        return (bool)$this->currentValues->getValue(self::ON_HORSEBACK);
    }

    public function getRidingAnimalsWithHeight(): array
    {
        $withSameHeight = [];
        foreach (RidingAnimalCode::getPossibleValues() as $ridingAnimalName) {
            switch ($ridingAnimalName) {
                case RidingAnimalCode::DONKEY :
                    $withSameHeight['1.1'][] = [$ridingAnimalName => RidingAnimalCode::getIt($ridingAnimalName)];
            }
        }

        $withWeight = [];
        foreach ($withSameHeight as $height => $animalsWithSameHeight) {
            $localizedAnimalsWithSameHeight = array_map(function (RidingAnimalCode $ridingAnimalCode) {
                return $ridingAnimalCode->translateTo('cs');
            }, $animalsWithSameHeight);
            $withWeight[$height] = implode(', ', $localizedAnimalsWithSameHeight);
        }

        return $withWeight;
    }
}