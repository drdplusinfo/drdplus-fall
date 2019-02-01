<?php
namespace DrdPlus\Tests\FallCalculator;

use DrdPlus\Codes\Armaments\BodyArmorCode;
use DrdPlus\Codes\Armaments\HelmCode;
use DrdPlus\Tests\RulesSkeleton\Partials\AbstractContentTest;
use Granam\DiceRolls\Templates\DiceRolls\Dice1d6Roll;
use Granam\DiceRolls\Templates\Rolls\Roll1d6;

class FallControllerTest extends AbstractContentTest
{

	/**
	 * @test
	 * @backupGlobals enabled
	 */
	public function I_can_ask_it_if_specific_helm_is_selected(): void
	{
		self::assertTrue(
			$this->createController()->isHelmSelected(HelmCode::getIt(HelmCode::WITHOUT_HELM)),
			"Expected current helm to be 'without helm'"
		);
		self::assertFalse($this->createController()->isHelmSelected(HelmCode::getIt(HelmCode::BARREL_HELM)));
		$_GET[FallController::HELM] = HelmCode::BARREL_HELM;
		self::assertTrue($this->createController()->isHelmSelected(HelmCode::getIt(HelmCode::BARREL_HELM)));
		self::assertFalse($this->createController()->isHelmSelected(HelmCode::getIt(HelmCode::CHAINMAIL_HOOD)));
	}

	private function createController(): FallController
	{
		return new FallController('https://example.com', $this->getProjectRoot(), $this->getDirs()->getVendorRoot());
	}

	/**
	 * @test
	 * @backupGlobals enabled
	 */
	public function I_can_get_selected_agility(): void
	{
		self::assertSame(0, $this->createController()->getSelectedAgility()->getValue());
		$_GET[FallController::AGILITY] = 123;
		self::assertSame(123, $this->createController()->getSelectedAgility()->getValue());
	}

	/**
	 * @test
	 * @backupGlobals enabled
	 */
	public function I_can_ask_it_if_fall_is_without_reaction(): void
	{
		self::assertFalse($this->createController()->isWithoutReaction(), 'Expected fall with reaction by default');
		$_GET[FallController::WITHOUT_REACTION] = 1;
		self::assertTrue($this->createController()->isWithoutReaction(), 'Expected fall without reaction because ordered so');
	}

	/**
	 * @test
	 * @backupGlobals enabled
	 */
	public function I_can_get_selected_bad_luck(): void
	{
		self::assertEquals(new Roll1d6(new Dice1d6Roll(1, 1)), $this->createController()->getCurrentBadLuck(), 'Expected 1 as default bad luck');
		$_GET[FallController::BAD_LUCK] = 5;
		self::assertEquals(new Roll1d6(new Dice1d6Roll(5, 1)), $this->createController()->getCurrentBadLuck());
	}

	/**
	 * @test
	 * @backupGlobals enabled
	 */
	public function I_can_get_selected_athletics(): void
	{
		self::assertSame(
			0,
			$this->createController()->getSelectedAthletics()->getCurrentSkillRank()->getValue(),
			'Expected zero skill rank of athletics by default'
		);
		$_GET[FallController::ATHLETICS] = 3;
		self::assertSame(
			3,
			$this->createController()->getSelectedAthletics()->getCurrentSkillRank()->getValue()
		);
	}

	/**
	 * @test
	 * @backupGlobals enabled
	 */
	public function I_can_ask_it_if_is_body_armor_selected(): void
	{
		self::assertTrue(
			$this->createController()->isBodyArmorSelected(BodyArmorCode::getIt(BodyArmorCode::WITHOUT_ARMOR)),
			"Expected default armor to be 'without armor'"
		);
		self::assertFalse($this->createController()->isBodyArmorSelected(BodyArmorCode::getIt(BodyArmorCode::FULL_PLATE_ARMOR)));
		$_GET[FallController::BODY_ARMOR] = BodyArmorCode::FULL_PLATE_ARMOR;
		self::assertFalse($this->createController()->isBodyArmorSelected(BodyArmorCode::getIt(BodyArmorCode::WITHOUT_ARMOR)));
		self::assertTrue($this->createController()->isBodyArmorSelected(BodyArmorCode::getIt(BodyArmorCode::FULL_PLATE_ARMOR)));
	}
}
