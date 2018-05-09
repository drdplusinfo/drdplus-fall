<?php
namespace DrdPlus\Calculator\Fall;

include_once __DIR__ . '/vendor/autoload.php';

error_reporting(-1);
ini_set('display_errors', '1');

/** @noinspection PhpUnusedLocalVariableInspection */
$controller = new FallController();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-type" content="text/html;charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/generic/vendor/bootstrap.4.0.0/bootstrap-reboot.min.css" rel="stylesheet" type="text/css">
    <link href="css/generic/vendor/bootstrap.4.0.0/bootstrap-grid.min.css" rel="stylesheet" type="text/css">
    <link href="css/generic/vendor/bootstrap.4.0.0/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="css/generic/graphics.css" rel="stylesheet" type="text/css">
    <link href="css/generic/skeleton.css" rel="stylesheet" type="text/css">
    <link href="css/generic/issues.css" rel="stylesheet" type="text/css">
    <link href="css/fall.css" rel="stylesheet" type="text/css">
    <noscript>
      <link href="css/generic/no_script.css" rel="stylesheet" type="text/css">
    </noscript>
  </head>
  <body class="container">
    <div class="background"></div>
      <?php include __DIR__ . '/vendor/drd-plus/calculator-skeleton/history_deletion.php' ?>
    <div class="row">
      <hr class="col">
    </div>
    <form action="" method="get" id="configurator">
        <?php
        include __DIR__ . '/parts/falling.php';
        include __DIR__ . '/parts/reaction.php';
        include __DIR__ . '/parts/armor.php';
        include __DIR__ . '/parts/result.php'; ?>
    </form>
    <div class="row">
      <hr class="col">
    </div>
    <div class="row">
      <a class="col" href="https://pph.drdplus.info/#skoky_a_pady_z_vysky">Pravidla pro zranění při pádu v PPH</a>
    </div>
      <?php
      /** @noinspection PhpUnusedLocalVariableInspection */
      $sourceCodeUrl = 'https://github.com/jaroslavtyc/drd-plus-fall';
      include __DIR__ . '/vendor/drd-plus/calculator-skeleton/issues.php' ?>
    <script type="text/javascript" src="js/fall.js"></script>
    <script type="text/javascript" src="js/generic/skeleton.js"></script>
  </body>
</html>
