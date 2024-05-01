<?php

namespace App\Repositories;

use App\Models\TimetableModel;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Services\RatingService;
use App\Models\DefaultConfigs;//minFinalMark
use App\Http\Helpers\GeneralHelpers\GeneralHelper;
use App\Http\Helpers\EstimationDayHelpers\EstimationDayHelper;
use App\Http\Helpers\EstimationDayHelpers\AutomaticEstimationHelper;
use Illuminate\Support\Facades\Log;

class EstimationRepository
{
    private $userRatings = null;
    private $defaultConfigs = null;

    public function __construct(RatingService $userRatings, DefaultConfigs $defaultConfigs)
    {
        $this->userRatings    = $userRatings;
        $this->defaultConfigs = $defaultConfigs;
    }

    /*This method will be executing automaticly for all users with unclosed plan in the end of the day (23:59) */
    public function estimate()
    {
        $ids = $this->getIds(); //Получаю id всех пользователей  с составленным на сегодня планом
        //Here I get all weekend guys
        $weekendIds = AutomaticEstimationHelper::getWeekendIds();
        //Here I get ids of bad guys
        $badIds = AutomaticEstimationHelper::getBadIds(); //получаю id тех юзеров, кто вообще не составил на сегодня план
        //end
        $date = GeneralHelper::getTodayDate();
       
            /*Count final mark for every user with plan*/
            foreach ($ids as $id) {
                $timetableId = GeneralHelper::getCurrentTimetableId(['id' => $id]);
                $finalMark = $this->sumMarks($timetableId); //считаю оценку каждого юзера
                $data = [
                    'timetable_id' => $timetableId,
                    'user_id' => $id,
                    'final_time' =>
                        $finalMark >= 50
                            ? $this->sumTime($timetableId)
                            : '00:00',
                    'final_estimation' => $finalMark >= 50 ? $finalMark : 0,
                    'own_estimation' => $finalMark,
                    'comment' => 'Closed automatically',
                    'date' => Carbon::today()->toDateString(),
                    'day_status' => $finalMark >= 50 ? 3 : -1,
                    'updated_at' => Carbon::now(),
                ];

                $finalMark >= 50
                    ? $this->userRatings->estimateActiveDayrating(2)
                    : $this->userRatings->estimateActiveDayrating(0);

                $this->fillTimetablesTable($data, $ids);
            }
        
            /*Estimate lazy guys*/
            foreach ($badIds as $id) {
                $data = [
                    // 'user_id' => $id,
                    // 'final_time' => '00:00',
                    // 'final_estimation' => -1,
                    // 'own_estimation' => -1,
                    // 'date' => Carbon::today()->toDateString(),
                    // 'comment' => 'It looks like the day was wasted :(',
                    // 'day_status' => -1,
                    // 'updated_at' => Carbon::now(),
                ];

                $this->userRatings->estimateLazyDayrating(0);
                $this->fillTimetablesTable($data, $badIds, 1);
            }

            foreach ($weekendIds as $id) {
                /*Here I have to check either guy */
                $timetableId = GeneralHelper::getCurrentTimetableId(['id' => $id]);
                $data = [
                    'timetable_id' => $timetableId,
                    'user_id' => $id,
                    'final_time' => $this->sumTime($timetableId),
                    'final_estimation' => 0,
                    'own_estimation' => 50,
                    'date' => GeneralHelper::getTodayDate(),
                    'day_status' => 1,
                    'comment' =>
                        'Closed automatically at ' .
                        Carbon::now()->toDateTimeString(),
                    'updated_at' => Carbon::now(),
                ];
                $this->userRatings->estimateActiveDayrating(1);
                $this->fillTimetablesTable($data, $weekendIds, 0);
            }
        
    }

    /*This method will be executing for concrete user on demand*/
    public function closeDay(array $data)
    {
        $timetableId = GeneralHelper::getCurrentTimetableId();
        $getDayStatus = GeneralHelper::getDayStatus();
        $tagsForTomorow = EstimationDayHelper::getTagsForTomorow($data['tomorow']);
        //close weekend
        if ($getDayStatus == 1) {
            $data = EstimationDayHelper::prepareData(1, ['comment' => $data['comment'], 'for_tomorrow' => $tagsForTomorow, 'own_estimation' => $data['mark'] ]);
            TimetableModel::find($timetableId)->update($data);

            return true;
        }
        //end
        $finalMark = EstimationDayHelper::sumMarks(); //считаю оценку юзера
       
        $defaultConfigs = json_decode(DefaultConfigs::select('config_data')->where('config_block_id', 2)->get()->toArray()[0]['config_data']);
        if ($finalMark >= $defaultConfigs->cardRules[0]->minFinalMark ) {
            $data = EstimationDayHelper::prepareData(2, ['comment' => $data['comment'], 'for_tomorrow' => $tagsForTomorow, 'own_estimation' => $data['mark']]);
            //update user`s plan state
            TimetableModel::find($timetableId)->update($data);

            return true;
        }

        return false;
    }

    public function getEmergencyCall(array $data)
    {
        // $mutable = Carbon::now();
        $mutable = new Carbon($data['from']);
        $id = Auth::id();
        // $dataForDayPlanCreation["date"]  = Carbon::today();
        $dataForDayPlanCreation['date'] = $data['from'];
        $dataForDayPlanCreation['user_id'] = $id;
        $dataForDayPlanCreation['day_status'] = 0;
        $dataForDayPlanCreation['final_estimation'] = 0;
        $dataForDayPlanCreation['own_estimation'] = 0;
        $dataForDayPlanCreation['comment'] = $data['comment'];
        $dataForDayPlanCreation['updated_at'] = DB::raw('CURRENT_TIMESTAMP(0)');
        $timetableCount = count(
            DB::table('timetables')
                ->where([
                    ['date', '=', Carbon::today()->toDateString()],
                    ['user_id', '=', $id],
                ])
                ->get()
                ->toArray()
        );


        for ($i = 0; $i < $data['term']; $i++) {
            if (
                !$i &&
                $timetableCount &&
                $data['from'] == Carbon::today()->toDateString()
            ) {
                DB::table('timetables')
                    ->where([
                        ['date', '=', Carbon::today()->toDateString()],
                        ['user_id', '=', $id],
                        ['day_status', '!=', 0],
                    ])
                    ->update([
                        'time_of_day_plan' => '00:00',
                        'final_estimation' => 0,
                        'own_estimation' => 0,
                        'day_status' => 0,
                        'comment' => $data['comment'],
                        'necessary' => '',
                        'for_tomorrow' => '',
                    ]);
                continue;
            }

            if ($timetableCount) {
                if ($data['from'] == Carbon::today()->toDateString()) {
                    $dataForDayPlanCreation['date'] = $mutable->add(1, 'day');
                    TimetableModel::insert($dataForDayPlanCreation);
                } else {
                    TimetableModel::insert($dataForDayPlanCreation);
                    $dataForDayPlanCreation['date'] = $mutable->add(1, 'day');
                }
            } else {
                TimetableModel::insert($dataForDayPlanCreation);
                $dataForDayPlanCreation['date'] = $mutable->add(1, 'day');
            }
        }

        return $data;
    }

    /*This method returns all final info about day: final_mark, own_mark, comment */
    public function getFinalInfoForTheDay(array $data)
    {
        $query =
            "SELECT time_of_day_plan, final_estimation, own_estimation, comment FROM timetables WHERE
                   date = '" .
            $data['date'] .
            "' AND user_id = " .
            $data['id'] .
            '';
        $response = DB::select($query);

        return $response;
    }

    /**
     * also use it in EditTaskService  
     */
    public function sumTime($timetableId)
    {
        $query = "SELECT SEC_TO_TIME( SUM(TIME_TO_SEC (STR_TO_DATE(`time`, '%H:%i') ) ) ) AS Sum_Of_time FROM tasks WHERE `timetable_id` = $timetableId";
        $timeOfPlan = DB::select($query);

        return $timeOfPlan[0]->Sum_Of_time;
    }

    private function fillTimetablesTable(array $data, array $ids, $badFlag = 0)
    {
        if (!$badFlag) {
            foreach ($ids as $id) {
                DB::table('timetables')
                    ->where([
                        ['id', '=', $data['timetable_id']],
                        ['user_id', '=', $data['user_id']],
                    ])
                    ->update([
                        'time_of_day_plan' => $data['final_time'], //time of plan info. Fix it later!!
                        'final_estimation' => $data['final_estimation'], //-2 - признак того, что день под статусом Вых
                        'own_estimation' => $data['own_estimation'],
                        'day_status' => $data['day_status'],
                        'comment' => $data['comment'],
                        'necessary' => '',
                        'for_tomorrow' => '',
                        'updated_at' => DB::raw('CURRENT_TIMESTAMP(0)'),
                    ]);
            }
        } else {
            foreach ($ids as $id) {
                $dataForDayPlanCreation['user_id'] = $id;
                $dataForDayPlanCreation['date'] = Carbon::today();
                $dataForDayPlanCreation['day_status'] = -1;
                $dataForDayPlanCreation['final_estimation'] = 0;
                $dataForDayPlanCreation['own_estimation'] = 0;
                $dataForDayPlanCreation['comment'] = $data['comment'];
                $dataForDayPlanCreation['updated_at'] = DB::raw(
                    'CURRENT_TIMESTAMP(0)'
                );
                TimetableModel::insert($dataForDayPlanCreation);
            }
        }
    }
}
