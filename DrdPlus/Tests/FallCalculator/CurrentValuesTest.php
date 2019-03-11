<?php
declare(strict_types=1);

namespace DrdPlus\Tests\FallCalculator;

use DrdPlus\Calculators\Fall\CurrentFallValues;
use DrdPlus\CalculatorSkeleton\CurrentValues;
use DrdPlus\Codes\Armaments\BodyArmorCode;
use DrdPlus\Codes\Armaments\HelmCode;
use DrdPlus\Tables\Tables;
use DrdPlus\Tests\CalculatorSkeleton\Partials\AbstractCalculatorContentTest;
use Granam\DiceRolls\Templates\DiceRolls\Dice1d6Roll;
use Granam\DiceRolls\Templates\Rolls\Roll1d6;
use Mockery\MockInterface;

/**
 * @backupGlobals enabled
 */
class CurrentValuesTest extends AbstractCalculatorContentTest
{

    /**
     * @test
     */
    public function I_can_ask_it_if_specific_helm_is_selected(): void
    {
        self::assertTrue(
            $this->createCurrentFallValues()->isHelmSelected(HelmCode::getIt(HelmCode::WITHOUT_HELM)),
            "Expected current helm to be 'without helm' as a  default one"
        );
        self::assertFalse($this->createCurrentFallValues()->isHelmSelected(HelmCode::getIt(HelmCode::BARREL_HELM)));
        $_GET[CurrentFallValues::HELM] = HelmCode::BARREL_HELM;
        self::assertTrue($this->createCurrentFallValues()->isHelmSelected(HelmCode::getIt(HelmCode::BARREL_HELM)));
        self::assertFalse($this->createCurrentFallValues()->isHelmSelected(HelmCode::getIt(HelmCode::CHAINMAIL_HOOD)));
    }

    private function createCurrentFallValues(): CurrentFallValues
    {
        return new CurrentFallValues($this->createCurrentValues(), Tables::getIt());
    }

    /**
     * @return CurrentValues|MockInterface
     */
    private function createCurrentValues(): CurrentValues
    {
        $currentValues = $this->mockery(CurrentValues::class);
        $currentValues->shouldReceive('getCurrentValue')
            ->andReturnUsing(function (string $name) {
                return $_GET[$name] ?? null;
            });

        return $currentValues;
    }

    /**
     * @test
     */
    public function I_can_get_selected_agility(): void
    {
        self::assertSame(0, $this->createCurrentFallValues()->getSelectedAgility()->getValue());
        $_GET[CurrentFallValues::AGILITY] = 123;
        self::assertSame(123, $this->createCurrentFallValues()->getSelectedAgility()->getValue());
    }

    /**
     * @test
     */
    public function I_can_ask_it_if_fall_is_without_reaction(): void
    {
        self::assertFalse($this->createCurrentFallValues()->isWithoutReaction(), 'Expected fall with reaction by default');
        $_GET[CurrentFallValues::WITHOUT_REACTION] = 1;
        self::assertTrue($this->createCurrentFallValues()->isWithoutReaction(), 'Expected fall without reaction because ordered so');
    }

    /**
     * @test
     */
    public function I_can_get_selected_bad_luck(): void
    {
        self::assertEquals(new Roll1d6(new Dice1d6Roll(1, 1)), $this->createCurrentFallValues()->getCurrentBadLuck(), 'Expected 1 as default bad luck');
        $_GET[CurrentFallValues::BAD_LUCK] = 5;
        self::assertEquals(new Roll1d6(new Dice1d6Roll(5, 1)), $this->createCurrentFallValues()->getCurrentBadLuck());
    }

    /**
     * @test
     */
    public function I_can_get_selected_athletics(): void
    {
        self::assertSame(
            0,
            $this->createCurrentFallValues()->getSelectedAthletics()->getCurrentSkillRank()->getValue(),
            'Expected zero skill rank of athletics by default'
        );
        $_GET[CurrentFallValues::ATHLETICS] = 3;
        self::assertSame(
            3,
            $this->createCurrentFallValues()->getSelectedAthletics()->getCurrentSkillRank()->getValue()
        );
    }

    /**
     * @test
     */
    public function I_can_ask_it_if_is_body_armor_selected(): void
    {
        self::assertTrue(
            $this->createCurrentFallValues()->isBodyArmorSelected(BodyArmorCode::getIt(BodyArmorCode::WITHOUT_ARMOR)),
            "Expected default armor to be 'without armor'"
        );
        self::assertFalse($this->createCurrentFallValues()->isBodyArmorSelected(BodyArmorCode::getIt(BodyArmorCode::FULL_PLATE_ARMOR)));
        $_GET[CurrentFallValues::BODY_ARMOR] = BodyArmorCode::FULL_PLATE_ARMOR;
        self::assertFalse($this->createCurrentFallValues()->isBodyArmorSelected(BodyArmorCode::getIt(BodyArmorCode::WITHOUT_ARMOR)));
        self::assertTrue($this->createCurrentFallValues()->isBodyArmorSelected(BodyArmorCode::getIt(BodyArmorCode::FULL_PLATE_ARMOR)));
    }
}