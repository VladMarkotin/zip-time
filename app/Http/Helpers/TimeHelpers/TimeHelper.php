<?php
namespace App\Http\Helpers\TimeHelpers;  


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use App\Models\User;
use App\Http\Helpers\GeneralHelpers\GeneralHelper;
use Illuminate\Support\Facades\Log;

class TimeHelper
{
    public static function getTimezonesWithTime($controlTime) :array //0-array, 1-string
    {
        $currentTimezone = [];
        $timezones = self::getUniqueTimezones();
        // Log::info(json_encode($timezones));
        // die;
        foreach ($timezones as $timezone) {
            $time = GeneralHelper::getNow($timezone); 
            //Log::info($time->hour); 
            if ($time->hour == $controlTime) {
                array_push($currentTimezone, $time->getTimezone()->getName());   // if hour in that timezone == 23:59(end of day) push user to array
            }
        }

        return $currentTimezone;
    }

    public static function getUniqueTimezones()
    {
        return User::select('timezone')->distinct()->pluck('timezone')->toArray();
    }
}