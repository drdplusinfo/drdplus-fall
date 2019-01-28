<?php
namespace DrdPlus\Professions\EnumTypes;

use Doctrineum\Scalar\ScalarEnumType;
use DrdPlus\Codes\ProfessionCode;
use DrdPlus\Professions\Commoner;
use DrdPlus\Professions\Fighter;
use DrdPlus\Professions\Priest;
use DrdPlus\Professions\Ranger;
use DrdPlus\Professions\Theurgist;
use DrdPlus\Professions\Thief;
use DrdPlus\Professions\Wizard;

class ProfessionType extends ScalarEnumType
{
    const PROFESSION = 'profession';

    public static function registerProfessionsAsSubtypes(): bool
    {
        $result = false;
        foreach (static::getProfessions() as $professionClass => $professionCode) {
            if (!static::hasSubTypeEnum($professionClass)) {
                $result = static::addSubTypeEnum($professionClass, '~^' . $professionCode . '$~') || $result;
            }
        }

        return $result;
    }

    protected static function getProfessions(): array
    {
        return [
            Commoner::class => ProfessionCode::COMMONER,
            Fighter::class => ProfessionCode::FIGHTER,
            Wizard::class => ProfessionCode::WIZARD,
            Priest::class => ProfessionCode::PRIEST,
            Theurgist::class => ProfessionCode::THEURGIST,
            Thief::class => ProfessionCode::THIEF,
            Ranger::class => ProfessionCode::RANGER,
        ];
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return self::PROFESSION;
    }
}