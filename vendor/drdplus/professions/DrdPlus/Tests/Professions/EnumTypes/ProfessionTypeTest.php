<?php
namespace DrdPlus\Tests\Professions\EnumTypes;

use Doctrine\DBAL\Types\Type;
use Doctrineum\Tests\SelfRegisteringType\AbstractSelfRegisteringTypeTest;
use DrdPlus\Professions\Commoner;
use DrdPlus\Professions\EnumTypes\ProfessionsEnumRegistrar;
use DrdPlus\Professions\EnumTypes\ProfessionType;
use DrdPlus\Professions\Fighter;
use DrdPlus\Professions\Priest;
use DrdPlus\Professions\Ranger;
use DrdPlus\Professions\Theurgist;
use DrdPlus\Professions\Thief;
use DrdPlus\Professions\Wizard;

class ProfessionTypeTest extends AbstractSelfRegisteringTypeTest
{

    /**
     * @test
     */
    public function I_got_registered_subtypes_even_if_profession_is_already_registered()
    {
        if (!Type::hasType($this->getExpectedTypeName())) {
            Type::addType($this->getExpectedTypeName(), $this->getTypeClass());
        }
        self::assertTrue(Type::hasType($this->getExpectedTypeName()));

        ProfessionsEnumRegistrar::registerAll();
        self::assertTrue(ProfessionType::hasSubTypeEnum(Commoner::class));
        self::assertTrue(ProfessionType::hasSubTypeEnum(Fighter::class));
        self::assertTrue(ProfessionType::hasSubTypeEnum(Wizard::class));
        self::assertTrue(ProfessionType::hasSubTypeEnum(Priest::class));
        self::assertTrue(ProfessionType::hasSubTypeEnum(Theurgist::class));
        self::assertTrue(ProfessionType::hasSubTypeEnum(Thief::class));
        self::assertTrue(ProfessionType::hasSubTypeEnum(Ranger::class));
    }
}