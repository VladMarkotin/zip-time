<?php
namespace App\Http\Controllers\Services\Challenges;


use App\Http\Controllers\Services\Challenges\Contracts\ChallengeContract;
use DB;
use App\Models\UsersChallenges;
use Auth;

class CompleteNTasks implements ChallengeContract
{
    private $index = null;
    private $rules = null;

    public function doChallenge(array $data)
    {
        //получить условие конкурса +
        $this->rules = $data['terms']->rules;
        //высчитать текущий результат
        $this->index = $this->countIndex($data);
        //высчитать процент выполнения 
        $result = $this->getCompletnesPercent($data);
        //Записать результат в базу
        UsersChallenges::where([
            ['user_id', Auth::id()],
            ['challenge_id', $data['ch_id']]
        ])->update([
            'completeness' => $result,
        ]);
        //получить награду
        // var_dump(1);
        // die;
    }

    public function countIndex($data)
    {
        return DB::select($data['query'])[0]->q;
    }

    public function getCompletnesPercent($data)
    {
        if ($this->rules->goal != 0) {
            return round( ($this->index / $this->rules->goal * 100), 1);
        }
    }

    public function checkRules(array $data)
    {}
}