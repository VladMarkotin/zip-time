<?php
namespace App\Http\Controllers\Services\PersonalResultServices\traits;


use App\Models\User;

trait UserGroupTrait
{
    public static function countUsersInGroupToday($data, $config)
    {
       $group = self::defineRateGroup($data, $config);
       $result = User::whereBetween('rating', [$group->from, $group->to])->count();
       
       return ['quantityInGroup' => $result - 1, 'group' => $group];//except the user   
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