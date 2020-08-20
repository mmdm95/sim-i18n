<?php
include_once 'config.php';

$userName = 'MMDM';
?>

<!doctype html>
<html lang="<?= $translate->getLanguage(); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body <?= $translate->isRTL() ? 'style="text-align: right; direction: rtl;"' : ''; ?>>
<h4><?= $translate->translate('current-lang') . $translate->getLanguage(); ?></h4>
<p>
    <?= $translate->translate('greeting', ['user' => $userName]); ?>
</p>

<label><?= $translate->translate('labels.test'); ?></label>
</body>
</html>
