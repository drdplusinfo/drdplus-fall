<?php
namespace DrdPlus\Professions;

class Commoner extends Profession
{
    /**
     * @return Commoner|Profession
     */
    public static function getIt(): Commoner
    {
        return parent::getIt();
    }

    /**
     * @return array
     */
    public function getPrimaryProperties(): array
    {
        return [];
    }
}