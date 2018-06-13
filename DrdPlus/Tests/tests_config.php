<?php
global $testsConfiguration;
$testsConfiguration = new \DrdPlus\Tests\FrontendSkeleton\TestsConfiguration();
$testsConfiguration->disableHasCustomBodyContent();
$testsConfiguration->disableHasTables();
$testsConfiguration->disableHasNotes();
$testsConfiguration->disableHasExternalAnchorsWithHashes();
$testsConfiguration->disableHasLinksToAltar();
$testsConfiguration->disableHasIds();
$testsConfiguration->setExpectedWebName('DrD+ kalkulátor zranění při pádu');
$testsConfiguration->setExpectedPageTitle('DrD+ kalkulátor zranění při pádu');