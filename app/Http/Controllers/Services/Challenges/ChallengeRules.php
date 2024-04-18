<?php
namespace App\Http\Controllers\Services\Challenges;


use DB;
use App\Models\UsersChallenges;
use Illuminate\Support\Facades\Log;
use Auth;

class ChallengeRules
{
    public static function checkChallengeRules(array $data)
    {
        $result = DB::select($data['preparedFailQuery']);
        if ($result[0]->result  >= $data['fail_goal']) {
            $completness = self::getCurrentCompletness($data);
            Log::info('Fail challenge');
            //fine has to be negative digit !
            $newCompletness = $completness[0]['completeness'] + $data['fine'];
            $newCompletness = ($newCompletness > 0) ?  $newCompletness : 0;
            Log::info($newCompletness);
            // die;

            UsersChallenges::where([
                ['user_id', Auth::id()],
                ['challenge_id', $data['chId'] ] 
            ])->update([
                'completeness' => $newCompletness,
            ]);

            return false;
        }

        return true;
    }

    private static function getCurrentCompletness(array $data)
    {
        return (UsersChallenges::select(['completeness'])->where([
            ['user_id', Auth::id()],
            ['challenge_id', $data['chId'] ] 
        ])
        ->get()
        ->toArray() );
    }
}
