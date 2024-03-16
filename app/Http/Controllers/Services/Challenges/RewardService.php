<?php
namespace App\Http\Controllers\Services\Challenges;


use Auth;
use DB;
use App\Models\ChallengeModel;
use App\Models\UsersChallenges;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Services\Challenges\CompleteNTasks;
use App\Http\Controllers\Services\Challenges\Contracts\ReplacementsClass;
use App\Models\User;

class RewardService 
{
    public static function reward(array $data)
    {
        if ($data['completness'] == 100 && ($data['isActive'])) { //challenge has been complete NOT FULL VERSION. 
            
            $currentRating = User::select('rating')->where('id','=', Auth::id())
              ->get()->toArray()[0]['rating'];
            UsersChallenges::where([
                ['user_id', Auth::id()],
                ['challenge_id', $data['chId'] ] 
            ])->update([
                'is_active' => 0,
                'completeness' => 100,
            ]);
            //die(var_dump($reward->rating));
            User::where([
                ['id', Auth::id()]
            ])->update([
                'rating' => ($currentRating + $data['reward']->rating),
            ]);
        }
    }
}