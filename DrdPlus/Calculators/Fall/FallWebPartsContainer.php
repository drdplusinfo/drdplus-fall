<?php
declare(strict_types=1);

namespace DrdPlus\Calculators\Fall;

use DrdPlus\CalculatorSkeleton\Web\CalculatorWebPartsContainer;
use DrdPlus\RulesSkeleton\Dirs;
use DrdPlus\RulesSkeleton\HtmlHelper;
use DrdPlus\RulesSkeleton\Request;
use DrdPlus\RulesSkeleton\Web\Pass;
use DrdPlus\RulesSkeleton\Web\WebFiles;

class FallWebPartsContainer extends CalculatorWebPartsContainer
{
    /**
     * @var CurrentFallValues
     */
    private $currentFallValues;

    public function __construct(Pass $pass, WebFiles $webFiles, Dirs $dirs, HtmlHelper $htmlHelper, Request $request, CurrentFallValues $currentFallValues)
    {
        parent::__construct($pass, $webFiles, $dirs, $htmlHelper, $request);
        $this->currentFallValues = $currentFallValues;
    }

    public function getCurrentFallValues(): CurrentFallValues
    {
        return $this->currentFallValues;
    }
}