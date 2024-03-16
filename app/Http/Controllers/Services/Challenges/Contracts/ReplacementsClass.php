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
            '{test_id}' => (function () {
                return 1851;
            }),
            '{test_id2}' => (function () {
                return 1853;
            }),
            '{minTestMark}' => (function ($index = 'minTestMark') {
                return 89;
            }),
        ];
    }

    public static function getReplacements()
    {
        self::assignValues();

        return self::$replacements;
    }
}