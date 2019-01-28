<?php
namespace DrdPlus\Professions\EnumTypes;

class ProfessionsEnumRegistrar
{
    public static function registerAll()
    {
        ProfessionType::registerSelf();
        ProfessionType::registerProfessionsAsSubtypes();
    }
}
