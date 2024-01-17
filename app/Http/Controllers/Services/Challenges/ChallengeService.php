<?php
namespace App\Http\Controllers\Services\Challenges;


use Auth;
use DB;
use App\Models\ChallengeModel;
use App\Models\UsersChallenges;
use App\Http\Controllers\Services\Challenges\CompleteNTasks;

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
     *   'query' - сформированный sql запрос. Должен вернуть одно значение!
     *   'terms' 
     *   'fails'
     *   'goals' - число, с которым можно будет савнить результат
     * ]
     */
    public function doChallenge(array $data)
    {
        $index = $this->countIndex($data);
        $goal = $this->getParam($data, 'goal');
        $completnes = $this->completnesPercent($index, $goal);
        $chId = $this->getChallengeId($data);
        $result = [
            
            'completeness' => $completnes,
            'updated_at' => DB::raw('CURRENT_TIMESTAMP(0)'),
        ];
        if ($completnes) {
            UsersChallenges::where('challenge_id', $chId)
            ->where(
                    'user_id' ,Auth::id()
            )
            ->update($result);
        }

        return ($completnes);
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
