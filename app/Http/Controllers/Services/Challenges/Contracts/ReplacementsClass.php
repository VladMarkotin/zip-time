<?php
namespace App\Http\Controllers\Services\Challenges\Contracts;


use Auth;
use App\Http\Controllers\Services\Configs\DefaultConfigs;
use Carbon\Carbon;
use App\Models\ChallengeModel;
use App\Models\UsersChallenges;
use Illuminate\Support\Facades\Log;

class ReplacementsClass
{
    private static $replacements = [];

    public static function assignValues()
    {
        self::$replacements = [
            '{user_id}' => (function (){
                return Auth::id();
            }),
            '{minMark}' => (function ($index = 'minMark') {
                return DefaultConfigs::getOptionViaIndex($index);
            }),
            '{test_id}' => (function () {
                return 1851;
            }),
            '{test_id2}' => (function () {
                return 1853;
            }),
            '{minTestMark}' => (function ($index = 'minTestMark') {
                return 89;
            }),
            '{today}' => (function () {
                return Carbon::today()->toDateString();
            }),
            '{keep_going_start}' => (function () {
                $chId = ChallengeModel::select('id')->where(['index' => 'keep_going'])->get();
                // Log::info($chId[0]->id);
                // die;
                $r = UsersChallenges::select('created_at')->where([ ['user_id', Auth::id() ],
                ['challenge_id', $chId[0]->id] ]) //challenge_id of 'keep_going' challenge
                 ->get()->toArray()[0];

                 return Carbon::parse($r['created_at'])->format('Y-m-d');
            }),
            '{keep_going_end}' => (function () {
                $chId = ChallengeModel::select('id')->where(['index' => 'keep_going'])->get();

                $r = UsersChallenges::select('created_at')->where([ ['user_id', Auth::id() ],
                   ['challenge_id', $chId[0]->id] ]) //challenge_id of 'keep_going' challenge
                 ->get()->toArray()[0];
                $dateStart = Carbon::parse($r['created_at'])->format('Y-m-d');
                 
                return Carbon::createFromFormat('Y-m-d', $dateStart)->addWeek()->format('Y-m-d');
                // Log::info($dateEnd);
                // die;
            }),
        ];
    }

    public static function getReplacements()
    {
        self::assignValues();

        return self::$replacements;
    }
}