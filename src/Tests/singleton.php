<?php

use Sim\I18n\ISOLanguageCodes;
use Sim\I18n\TranslateSingleton;

include_once '../../vendor/autoload.php';

TranslateSingleton::getInstance()->setTranslateDir(__DIR__ . DIRECTORY_SEPARATOR . 'languages');
//    ->setLocale(ISOLanguageCodes::LANGUAGE_PERSIAN_FARSI);
//    ->setLocale(ISOLanguageCodes::LANGUAGE_FRENCH);
$userName = 'MMDM';
?>

<!doctype html>
<html lang="<?= TranslateSingleton::getInstance()->getLanguage(); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body <?= TranslateSingleton::getInstance()->isRTL() ? 'style="text-align: right; direction: rtl;"' : ''; ?>>
<h4><?= TranslateSingleton::getInstance()->translate('current-lang') . TranslateSingleton::getInstance()->getLanguage(); ?></h4>
<p>
    <?= TranslateSingleton::getInstance()->translate('greeting', ['user' => $userName]); ?>
</p>

<label><?= TranslateSingleton::getInstance()->translate('labels.test'); ?></label>
</body>
</html>
