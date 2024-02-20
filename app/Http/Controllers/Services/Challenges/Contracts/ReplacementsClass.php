<?php
namespace App\Http\Controllers\Services\Challenges\Contracts;


use Auth;
use App\Http\Controllers\Services\Configs\DefaultConfigs;

class ReplacementsClass
{
    private static $replacements = [];

    public static function assignValues()
    {
        self::$replacements = [
            '{user_id}' => (function (){
                return Auth::id();
            }),
            '{minMark}' => (function ($index = 'minMark') {
                return DefaultConfigs::getOptionViaIndex($index);
            }),
        ];
    }

    public static function getReplacements()
    {
        self::assignValues();

        return self::$replacements;
    }
}