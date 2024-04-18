<?php
namespace App\Http\Controllers\Services\Challenges;


use Auth;
use DB;
use App\Models\ChallengeModel;
use App\Models\UsersChallenges;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Services\Challenges\CompleteNTasks;
use App\Http\Controllers\Services\Challenges\RewardService;
use App\Http\Controllers\Services\Challenges\Contracts\ReplacementsClass;
use App\Models\User;

class ChallengeService
{
    private $challenges = [];

    public function __construct(CompleteNTasks $completeNTasks)
    {
        $this->challenges['completeNTasks'] = $completeNTasks;
    }
    /**
     * Wrapper for counting all indexes for challenge
     * $data = [
     *   'user_id' - сформированный sql запрос. Должен вернуть одно значение!
     *   'challenge_index' 
     */
    public function doChallenge(array $data)
    {
        /**
         * Have to get condithions of challenge
         */
        $terms = ChallengeModel::select('id','terms')->where('index', $data['index'])->get()->toArray();
        foreach ($terms as $val) {
            
            $chId = json_decode($val['id']);
            $isActive = UsersChallenges::select('is_active')->where([
                ['user_id', Auth::id()],
                ['challenge_id', $chId],
                ])
                ->get();
            if (isset($isActive[0])) {

                if ($isActive[0]->is_active) {
                        
                    $terms2 = json_decode($val['terms']);
                    $unPreparedQuery = $terms2->rules->query;
                    $unPreparedFailQuery = (isset($terms2->rules->terms->fail_query) ) 
                        ? $terms2->rules->terms->fail_query  : ''; 
                    //Log::info($unPreparedFailQuery);
                    //get replacement`s array. It is nessary for creating valid SQL Query. Here we change all {param} with real values
                    $replacements = ReplacementsClass::getReplacements();
                    foreach ($replacements as $k => $v) {
                        if ($unPreparedFailQuery) {
                            $unPreparedFailQuery = str_replace($k, $v(), $unPreparedFailQuery);
                        }
                        $unPreparedQuery = str_replace($k, $v(), $unPreparedQuery);
                    }
                    if ($unPreparedFailQuery) {
                        if (!ChallengeRules::checkChallengeRules([
                                'preparedFailQuery' => $unPreparedFailQuery,
                                'fine' => $terms2->rules->terms->fine,
                                'fail_goal' => $terms2->rules->terms->fail_goal,
                                'chId' => $chId,
                            ])
                        )
                           exit;
                    }
                    //For now in $unPreparedQuery placed preparedQuery!
                    //Log::info("$unPreparedQuery");
                    $result = DB::select($unPreparedQuery);
                    $completness = $result[0]->result / $terms2->rules->goal * 100;
                    $completness = ($completness >= 100) ? 100 : $completness; 
                    if ($result[0]->result < $terms2->rules->goal) {
                        UsersChallenges::where([
                            ['user_id', Auth::id()],
                            ['challenge_id', $chId] 
                        ])->update([
                            'completeness' => $completness,
                        ]);
                    }
                    $reward = $terms2->rules->reward;
                    RewardService::reward(
                        [
                            'completness' => $completness,
                            'reward'      => $reward,
                            'chId'        => $chId,
                            'isActive'   => $isActive,
                        ]
                    );
                }
            }    
        }
    }

    private function completnesPercent($index, $goal)
    {
        return $index / $goal *100;
    }

    private function getParam(array $data, $param)
    {
        $terms = ChallengeModel::select('terms')->where([['index', $data['index']]])->get()->toArray();
        $term = json_decode($terms[0]['terms']);
        if(isset($term->rules->$param)) {
            return $term->rules->$param;
        }

        return null;
    }

    private function getChallengeId(array $data)
    {
        return ChallengeModel::select('id')->where([['index', $data['index']]])->get();
    }

    private function countIndex($data)
    {
        $result = DB::select($data['query']);
        
        return ($result[0]->q);
    }
}
