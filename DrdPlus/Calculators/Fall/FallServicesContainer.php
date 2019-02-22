<?php
declare(strict_types=1);

namespace DrdPlus\Calculators\Fall;

use DrdPlus\CalculatorSkeleton\CalculatorServicesContainer;
use DrdPlus\RulesSkeleton\Web\WebPartsContainer;

class FallServicesContainer extends CalculatorServicesContainer
{
    /** @var CurrentFallValues */
    private $currentFallValues;
    /** @var FallWebPartsContainer */
    private $fallWebPartsContainer;

    public function getWebPartsContainer(): WebPartsContainer
    {
        if ($this->fallWebPartsContainer === null) {
            $this->fallWebPartsContainer = new FallWebPartsContainer(
                $this->getPass(),
                $this->getWebFiles(),
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
            $this->currentFallValues = new CurrentFallValues($this->getCurrentValues());
        }
        return $this->currentFallValues;
    }

}