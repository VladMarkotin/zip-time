<?php
/**
 * Created by PhpStorm.
 * User: Vlad
 * Date: 13.11.2021
 * Time: 12:35
 */

namespace App\Http\Controllers\Services;

use Carbon\Carbon;
use App\Models\TimetableModel;
use Illuminate\Support\Facades\Auth;

class EmergencyService
{
    private $timetableModel = null;

    public function __construct(TimetableModel $timetableModel)
    {
        $this->timetableModel = $timetableModel;
    }

    public function check(array $data)
    {
        $makeCommentRight = function () use($data) {
             if(strlen($data['comment']) < 5){
                 $data['comment'] = "Comment field is too short. Probably the reason of emergency call
                        wasn`t really clear for the user himself (It has to be 5+ symbols )";
             }else if(strlen($data['comment']) > 65535){
                 $data['comment'] = substr($data['comment'], 0, 65534);
             }

             return $data;
         };
        $makeTermRight    = function () use (&$data){
            $from = Carbon::parse($data['from']);
            $to  = Carbon::parse($data['to']);
            $term = $to->diffInDays($from);
            if(($term > 30)){
                $term = 30;
            } else if($term < 1){
                $term = 1;
            } else if ($term == 1) {
                $term += 1;
            } else {
                $term = ($term != 1) ? $term + 1: $term; //get right duration of emergency mode
            }
            $data['term'] = $term;

            return $data;
        };
        $data = $makeCommentRight();
        $data = $makeTermRight();

        return $data;
    }

    public function getEmergencyModeDates($from, $to = null) {
        $user_id = Auth::id();

        $query = $this->timetableModel::where('date', '>=', $from)
        ->where('day_status', '=', 0)
        ->where('user_id', $user_id);

        if (isset($to)) {
            $query->where('date', '<=', $to);
        }

        return $query->pluck('date')->toArray();
    }
} 