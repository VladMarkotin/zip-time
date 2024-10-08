<?php
namespace App\Http\Helpers\GeneralHelpers; 


use App\Models\TimetableModel;
use App\Models\User;
use Illuminate\Support\Carbon;
use Auth;

class GeneralHelper
{
    /**
     * Helpers for user
     */
    public static function getCurrentTimetableId(array $data = null)
    {
        $date = self::getTodayDate();
        if (!$data) {
            $response = TimetableModel::where('user_id', Auth::id())
                ->where('date', $date)
                ->pluck('id')
                ->toArray();
        } else {
            $response = TimetableModel::where('user_id', $data['id'])
                        ->where('date', $date)
                        ->where('day_status', 2)
                        ->pluck('id')
                        ->toArray();

        }
        
        return $response[0];
    }

    public static function getDayStatus()
    {
        $response = TimetableModel::where('id', self::getCurrentTimetableId())
                ->pluck('day_status')
                ->toArray();

        return $response[0];
    }

    public static function getTodayDate()
    {
        return Carbon::today()->toDateString();
    }

    public static function getNow($timezone = null)
    {
        if ($timezone) {
            return Carbon::now($timezone);
        }

        return Carbon::now();
    }

    public static function prepareSqlIn(array $data)
    {
        if (count($data)) {
            $result = array_map(function($item) {
                return "'".$item."'";
            }, $data);
                
            return implode(',', $result);
        }

        return [];
    }

    public static function checkIfEmergModeIsActive()
    {
        $today_date = self::getTodayDate();

        $day_status = TimetableModel::join('users', 'timetables.user_id', '=', 'users.id')
                    ->where('users.id', Auth::id())
                    ->where('timetables.date', $today_date)
                    ->value('day_status');
        
        if ($day_status === null) {
            return false;
        }
        
        return $day_status === 0;
    }

    public static function getUserTimeZone() 
    {
        $user_id = Auth::id();
        return User::find($user_id)->timezone;
    }

    public static function getUserTodayDate() {
        $user_time_zone = self::getUserTimeZone();
        return self::getNow($user_time_zone);
    }

    public static function checkIfDateIsLater($dateOne, $dateTwo)
    {
        return Carbon::createFromFormat('Y-m-d', $dateOne)->gt(Carbon::createFromFormat('Y-m-d', $dateTwo));
    }

    public static function checkIfDateIsCorrect($date) {
        $pattern = '/^\d{4}-\d{2}-\d{2}$/';

        if (!preg_match($pattern, $date)) {
            return false;
        }

        $carbonDate = Carbon::createFromFormat('Y-m-d', $date);
        
        return $carbonDate && $carbonDate->format('Y-m-d') === $date;
    }   

    public static function transformDateToDMY($date) {
        return Carbon::parse($date)->format('d-m-Y');
    }
}