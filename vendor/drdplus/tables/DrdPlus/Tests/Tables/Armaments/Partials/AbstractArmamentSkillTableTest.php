<?php
declare(strict_types=1); // on PHP 7+ are standard PHP methods strict to types of given parameters

namespace DrdPlus\Tests\Tables\Armaments\Partials;

use DrdPlus\Tests\Tables\TableTest;

abstract class AbstractArmamentSkillTableTest extends TableTest
{
    /**
     * @test
     * @expectedException \DrdPlus\Tables\Armaments\Partials\Exceptions\UnexpectedSkillRank
     */
    abstract public function I_can_not_use_negative_rank();

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Armaments\Partials\Exceptions\UnexpectedSkillRank
     */
    abstract public function I_can_not_use_higher_rank_than_three();
}