<?php

namespace Sim\I18n;

use Sim\I18n\Abstracts\AbstractSingleton;
use Sim\I18n\Interfaces\ITranslate;
use Sim\I18n\Traits\TraitTranslate;

class TranslateSingleton extends AbstractSingleton implements ITranslate
{
    use TraitTranslate;
}