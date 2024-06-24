<?php

namespace App;

use Illuminate\Support\Facades\App;

trait ExcellsusTrait
{
    public static function getAttributeLanguage():string
    {
        return App::isLocale('en') ? 'english' : 'spanish';
    }
}
