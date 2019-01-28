<?php
declare(strict_types=1);

namespace DrdPlus\Calculators\Fall;

use DrdPlus\CalculatorSkeleton\CalculatorServicesContainer;

class FallServicesContainer extends CalculatorServicesContainer
{
    /** @var CurrentFallValues */
    private $currentFallValues;

    public function getRulesMainBodyParameters(): array
    {
        return [
            'historyDeletion' => $this->getHistoryDeletionBody(),
            'currentFallValues' => $this->getCurrentFallValues(),
        ];
    }

    public function getCurrentFallValues(): CurrentFallValues
    {
        if ($this->currentFallValues === null) {
            $this->currentFallValues = new CurrentFallValues($this->getCurrentValues());
        }

        return $this->currentFallValues;
    }

}