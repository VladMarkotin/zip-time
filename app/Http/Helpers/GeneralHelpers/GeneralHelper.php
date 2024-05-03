<?php
namespace App\Http\Helpers\GeneralHelpers; 


use App\Models\TimetableModel;
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

    public function getDayStatus()
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

    public static function getNow()
    {
        return Carbon::now();
    }


}