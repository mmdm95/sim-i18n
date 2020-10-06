<?php

use Sim\I18n\ISOLanguageCodes;
use Sim\I18n\Translate;

include_once '../../vendor/autoload.php';
//include_once '../../autoloader.php';

$translate = new Translate();
//$translate->createLanguageFile(ISOLanguageCodes::LANGUAGE_FRENCH, __DIR__ . DIRECTORY_SEPARATOR . 'languages');
$translate->setTranslateDir(__DIR__ . DIRECTORY_SEPARATOR . 'languages');
//    ->setLocale(ISOLanguageCodes::LANGUAGE_PERSIAN_FARSI);
