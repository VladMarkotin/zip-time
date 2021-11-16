<?php
/**
 * Created by PhpStorm.
 * User: Vlad
 * Date: 13.11.2021
 * Time: 12:35
 */

namespace App\Http\Controllers\Services;

use Carbon\Carbon;
class EmergencyService
{
    public function check(array $data)
    {
        $makeCommentRight = function () use($data) {
             if(strlen($data['comment']) < 5){
                 $data['comment'] = "Comment field is empty. Probably the reason of emergency call
                        wasn`t really clear for the user himself";
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
            }
            $data['term'] = $term;

            return $data;
        };
        $data = $makeCommentRight();
        $data = $makeTermRight();

        return $data;
    }
} 