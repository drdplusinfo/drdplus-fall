<?php declare(strict_types=1);

namespace DrdPlus\Calculators\Fall;

use DrdPlus\RulesSkeleton\Dirs;

class FallDirs extends Dirs
{
    public function getWebRoot(): string
    {
        return parent::getWebRoot() . '/web';
    }

}