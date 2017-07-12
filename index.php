<?php
namespace DrdPlus\Fight;

include_once __DIR__ . '/vendor/autoload.php';

error_reporting(-1);
ini_set('display_errors', '1');

$controller = new Controller();
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-type" content="text/html;charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/generic/graphics.css" rel="stylesheet" type="text/css">
    <link href="css/generic/main.css" rel="stylesheet" type="text/css">
    <link href="css/generic/socials.css" rel="stylesheet" type="text/css">
    <link href="css/main.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="js/generic/main.js"></script>
    <script type="text/javascript" src="js/generic/facebook.js" async></script>
    <noscript>
        <link rel="stylesheet" type="text/css" href="css/generic/no_script.css">
    </noscript>
</head>
<body>
<div id="fb-root"></div>
<div class="background"></div>
<form class="block delete" action="/" method="post" onsubmit="return window.confirm('Opravdu smazat?')">
    <label>
        <input type="submit" value="Smazat" name="<?= $controller::DELETE_HISTORY ?>">
        <span class="hint">(včetně dlouhodobé paměti)</span>
    </label>
</form>
<form class="block" action="" method="get">
    <div class="block remember">
        <label><input type="checkbox" name="<?= $controller::REMEMBER_HISTORY ?>" value="1"
                      <?php if ($controller->shouldRemember()) { ?>checked="checked"<?php } ?>>
            Pamatovat <span class="hint">(i při zavření prohlížeče)</span></label>
    </div>
    <div class="block">
        <div class="panel"><?php include __DIR__ . '/parts/falling.php'; ?></div>
        <div class="panel"><?php include __DIR__ . '/parts/reaction.php'; ?></div>
        <div class="panel"><?php include __DIR__ . '/parts/armor.php'; ?></div>
    </div>
    <div class="block"><?php include __DIR__ . '/parts/result.php'; ?></div>
</form>
<div class="block issues">
    <a href="https://github.com/jaroslavtyc/drd-plus-fall/issues">Máš nápad 😀? Vidíš chybu 😱?️ Sem s tím!</a>
</div>
<div class="block">
    <div class="fb-like facebook"
         data-href="https://pad.drdplus.info/<?= $_SERVER['QUERY_STRING'] ? ('?' . $_SERVER['QUERY_STRING']) : '' ?>"
         data-layout="button" data-action="recommend"
         data-size="small" data-show-faces="false" data-share="true"></div>
    <a href="https://github.com/jaroslavtyc/drd-plus-fall/"
       title="Fork me on GitHub"><img class="github" src="/images/generic/GitHub-Mark-64px.png"></a>
</div>
</body>
</html>
