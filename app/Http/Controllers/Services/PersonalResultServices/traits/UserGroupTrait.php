<?php
namespace App\Http\Controllers\Services\PersonalResultServices\traits;


use App\Models\User;
use DB;
use Illuminate\Support\Facades\Log;
use Auth;

trait UserGroupTrait
{
    public static function countUsersInGroupToday($data, $config)
    {
       $group = self::defineRateGroup($data, $config);
       if (isset($group->from) && isset($group->to)) {
           $result = User::whereBetween('rating', [$group->from, $group->to])->count();
       } else {
         //find max rating
         $result = User::where('rating', '>', 3200)
            ->where('rating', '<=', DB::table('users')->max('rating'))
            ->count();
            //find amount of users between users rating and max rating
            // Log::info(json_encode($group));
            // die;
       }
       
       return ['quantityInGroup' => $result, 'group' => $group];//except the user   
    }
    
     static function defineRateGroup($data, $config) {
        $conf = json_decode($config[0]['config_data']);
        $ratingGroup = []; 
        //have to define rating`s frames
        $isRatingBelongsToGroup = function (array $group, $rate) {
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
} 