<?php
global $testsConfiguration;
$testsConfiguration = new \DrdPlus\Tests\FrontendSkeleton\TestsConfiguration();
$testsConfiguration->disableHasCustomBodyContent();
$testsConfiguration->disableHasTables();
$testsConfiguration->disableHasNotes();
$testsConfiguration->disableHasExternalAnchorsWithHashes();
$testsConfiguration->disableHasLinksToAltar();
$testsConfiguration->setExpectedPageTitle('DrD+ kalkulátor zranění při pádu');