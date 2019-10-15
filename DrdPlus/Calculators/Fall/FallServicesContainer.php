<?php declare(strict_types=1);

namespace DrdPlus\Calculators\Fall;

use DrdPlus\CalculatorSkeleton\CalculatorServicesContainer;
use DrdPlus\RulesSkeleton\Web\WebPartsContainer;
use DrdPlus\Tables\Tables;

class FallServicesContainer extends CalculatorServicesContainer
{
    /** @var CurrentFallValues */
    private $currentFallValues;
    /** @var FallWebPartsContainer */
    private $fallWebPartsContainer;
    /** @var Tables */
    private $tables;

    public function getRoutedWebPartsContainer(): WebPartsContainer
    {
        if ($this->fallWebPartsContainer === null) {
            $this->fallWebPartsContainer = new FallWebPartsContainer(
                $this->getPass(),
                $this->getRoutedWebFiles(),
                $this->getDirs(),
                $this->getHtmlHelper(),
                $this->getRequest(),
                $this->getCurrentFallValues()
            );
        }
        return $this->fallWebPartsContainer;
    }

    public function getCurrentFallValues(): CurrentFallValues
    {
        if ($this->currentFallValues === null) {
            $this->currentFallValues = new CurrentFallValues($this->getCurrentValues(), $this->getTables());
        }
        return $this->currentFallValues;
    }

    public function getTables(): Tables
    {
        if ($this->tables === null) {
            $this->tables = Tables::getIt();
        }
        return $this->tables;
    }
}