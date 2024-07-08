<?php
namespace App\Http\Controllers\Services\PersonalResultServices\traits;


use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Auth;
use App\Http\Controllers\Services\Configs\DefaultConfigs;

trait UserGroupTrait
{
    public static function countUsersInGroupToday($data, $config)
    {
       $group = self::defineRateGroup($data, $config);
       //Log::info($data['current_rate']);//
    //    Log::info(DefaultConfigs::getOptionViaIndex());
    //    die;
       if (isset($group->from) && isset($group->to)) {
           $result = User::whereBetween('rating', [$group->from, $group->to])->count();
       } else {
        Log::info('Count result among All users');
         //find max rating
          $result = User::all()->count();
          //find amount of users between users rating and max rating
          //Log::info($result);
        }
       return ['quantityInGroup' => $result, 'group' => $group];//except the user   
    }
    
     static function defineRateGroup($data, $config) {
        $conf = json_decode($config[0]['config_data']);
        $ratingGroup = []; 
        //have to define rating`s frames
        $isRatingBelongsToGroup = function (array $group, $rate) {

            $minValRating = self::getBoundayValRating($group, 'min');
            $maxValRating = self::getBoundayValRating($group, 'max');

            if ($rate < $minValRating) {
                $group = ['from' => -INF, 'to' => $minValRating];
                return (object) $group;
            }
            if ($rate > $maxValRating) {
                $group = ['from' => $maxValRating, 'to' => INF];
                return (object) $group;
            }
            
            foreach ($group as $v) {
                if ($rate >= $v->from && ($rate <= $v->to)) { 
                    return $v;
                }
                continue;
            }
            return false;
        };
        foreach ($conf as $group) {
            if ($g = $isRatingBelongsToGroup($group, $data['current_rate'])) {
                return $g;
            }
        }
    }

    static function getBoundayValRating($groups, $flag) {
        $properties             = ['from', 'to'];
        $allGroupBoundaryValues = [];

        foreach($groups as $group) {
            foreach ($properties as $property) {
                if (is_numeric($group->$property)) {
                    $allGroupBoundaryValues[] = $group->$property;
                }
            }
        }

        switch($flag) {
            case 'min':
                return min($allGroupBoundaryValues);
            case 'max':
                return max($allGroupBoundaryValues);
            default:
                return null;
        }
    }
} 