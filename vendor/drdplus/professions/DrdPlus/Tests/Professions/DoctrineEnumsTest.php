<?php
namespace DrdPlus\Tests\Professions;

use Doctrineum\Tests\Entity\AbstractDoctrineEntitiesTest;
use DrdPlus\Professions\EnumTypes\ProfessionsEnumRegistrar;
use DrdPlus\Professions\EnumTypes\ProfessionType;
use DrdPlus\Professions\Fighter;
use DrdPlus\Professions\Priest;
use DrdPlus\Professions\Ranger;
use DrdPlus\Professions\Theurgist;
use DrdPlus\Professions\Thief;
use DrdPlus\Professions\Wizard;
use DrdPlus\Tests\Professions\Entities\SomeEntityWithProfessions;

class DoctrineEnumsTest extends AbstractDoctrineEntitiesTest
{
    protected function setUp()
    {
        ProfessionsEnumRegistrar::registerAll();
        parent::setUp();
    }

    protected function tearDown()
    {
        parent::tearDown();
        foreach ([Fighter::class, Priest::class, Ranger::class, Theurgist::class, Thief::class, Wizard::class] as $professionClass) {
            ProfessionType::removeSubTypeEnum($professionClass);
        }
    }

    protected function getDirsWithEntities()
    {
        return [__DIR__ . '/Entities'];
    }

    protected function createEntitiesToPersist(): array
    {
        return [
            new SomeEntityWithProfessions(Fighter::getIt(), null, null, null, null, null, Fighter::getIt()),
            new SomeEntityWithProfessions(null, Thief::getIt(), null, null, null, null, Thief::getIt()),
            new SomeEntityWithProfessions(null, null, Wizard::getIt(), null, null, null, Wizard::getIt()),
            new SomeEntityWithProfessions(null, null, null, Priest::getIt(), null, null, Priest::getIt()),
            new SomeEntityWithProfessions(null, null, null, null, Theurgist::getIt(), null, Theurgist::getIt()),
            new SomeEntityWithProfessions(null, null, null, null, null, Ranger::getIt(), Ranger::getIt()),
        ];
    }

}