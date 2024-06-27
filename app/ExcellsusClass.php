<?php

namespace App;

use Illuminate\Support\Facades\App;

class ExcellsusClass
{
    public static function getAttributeLanguage():string
    {
        return App::isLocale('en') ? 'english' : 'spanish';
    }
}
