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
        $terms2 = json_decode($terms[0]['terms']);
        $chId = json_decode($terms[0]['id']);
        /*Log::info($chId);
        exit;*/
        $unPreparedQuery = $terms2->rules->query;
        //get replacement`s array. It is nessary for creating valid SQL Query. Here we change all {param} on real values
        $replacements = ReplacementsClass::getReplacements();
        foreach ($replacements as $k => $v) {
            
            $unPreparedQuery = str_replace($k, $v(), $unPreparedQuery);
        }
       
        //For now in $unPreparedQuery placed preparedQuery!
        $result = DB::select($unPreparedQuery);
        $completness = $result[0]->result / $terms2->rules->goal * 100;
        $completness = ($completness >= 100) ? 100 : $completness; 
        if ($data['index'] == 'test_reward') {
             Log::info(($completness) );
        }
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
            ]
        );
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
