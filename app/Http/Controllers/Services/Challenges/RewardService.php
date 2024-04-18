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
            User::where([
                ['id', Auth::id()]
            ])->update([
                    'rating' => ($currentRating + $data['reward']->rating),
            ]);
            self::assignNewChToUser(['chId' => $data['chId']]);
                //die(var_dump($reward->rating));
        }
    }

    /**
     * array $data
     * args: ch_id
     */
    public static function assignNewChToUser(array $data)
    {
        //1. get next challenge`s index
        //Log::info("Next ch index:".var_export($data) );

        if (isset($data['chId'])) {

            $nextChIndex =  ChallengeModel::select('next_ch_index')->where([
                ['id', $data['chId'] ] 
            ])->get()->toArray();

            //Assign new challenges 
            if (isset($nextChIndex[0]['next_ch_index'])) {

                $nextChIndexArray = explode(';', $nextChIndex[0]['next_ch_index']);
                // Log::info("Next ch index:".json_encode($nextChIndexArray) );
                //if next ch exists, assign it to user
                if (count($nextChIndexArray) ) {
                    foreach ($nextChIndexArray as $v) {
                        $nextChId = ChallengeModel::select('id')->where([
                            ['index', $v ] 
                        ])->get()->toArray();

                        if (isset($nextChId[0]['id'] ) ) {

                            $dataForNewChallenge = [
                                "user_id"      => Auth::id(),
                                "challenge_id" => $nextChId[0]['id'],
                                'is_active'    => 1,
                                "created_at"   => DB::raw('CURRENT_TIMESTAMP(0)'),
                                "updated_at"   => DB::raw('CURRENT_TIMESTAMP(0)')
                            ];
                            UsersChallenges::insert($dataForNewChallenge);
                        }
                    }
                }
            }

        } elseif( isset($data['first_ch']) ) {
            $firstChId = ChallengeModel::select('id')->where([
                ['index', 'get_to_know' ] 
            ])->get()->toArray()[0]['id'];
            $dataForNewChallenge = [
                "user_id"      => Auth::id(),
                "challenge_id" => $firstChId,
                'is_active'    => 1,
                "created_at"   => DB::raw('CURRENT_TIMESTAMP(0)'),
                "updated_at"   => DB::raw('CURRENT_TIMESTAMP(0)')
            ];
            UsersChallenges::insert($dataForNewChallenge);
        }
    }
}