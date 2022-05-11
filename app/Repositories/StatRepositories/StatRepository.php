<?php
/**
 * Created by PhpStorm.
 * User: Vlad
 * Date: 26.11.2021
 * Time: 15:45
 */
namespace App\Repositories\StatRepositories;


use App\Repositories\StatRepositories\traits\AverageMarkTrait;
use App\Repositories\StatRepositories\traits\GetInfoForGraficTrait;
use App\Repositories\StatRepositories\traits\GeneralinfoTrait;
use Carbon\Carbon;

class StatRepository
{
    public function getStat(array $data, $option = 1)
    {
        $response = [];
        if($option == 1){ //get stat values
            switch(isset($data['date']) ){
                case true:
                    $response = $this->getStatForPeriod($data['date']);
                    break;
                case false: //get info for last week
                    $response = $this->getStatForPeriod($data);
                    break;
            }
        }else{ //get final_marks for period
            $response = $this->getStatValues($data);
        }

        return $response;
    }

    private function getStatForPeriod($period)
    {
        /*Get stat for the period. Stat means: AVG mark, AVG personal mark, Max Mark, Min Mark, Median Mark*/
        //$response['from']           = $period['from'];
        $response['from']           = Carbon::createFromFormat('Y-m-d' , $period['from'])->timestamp;
        //$response['to']             = $period['to'];
        $response['to']             = Carbon::createFromFormat('Y-m-d' , $period['to'])->timestamp;
        $response['completedDays']  = GeneralinfoTrait::getStat($period, 3);
        $response['failedDays']     = GeneralinfoTrait::getStat($period, -1);
        $response['emergencyModes'] = GeneralinfoTrait::getStat($period, 0);
        $response['weekends']       = GeneralinfoTrait::getStat($period, 1);
        $response['totalTime']      = AverageMarkTrait::getTotalTime($period);
        $response['avgMark']        = AverageMarkTrait::getAvgMark($period, 1);
        $response['ownAvgMark']     = AverageMarkTrait::getAvgMark($period, 2);
        $response['medianMark']     = AverageMarkTrait::getMedianValue($period);
        $response['medianOwnMark']  = AverageMarkTrait::getMedianValue($period, 2);
        $response['maxMark']        = AverageMarkTrait::getExtremum($period);
        $response['minMark']        = AverageMarkTrait::getExtremum($period, 2);
        /*
         * I have steal need to count:
         * Completed days quantity
         * Failed days quantity
         * Emergency calls quantity
         * Weekends quantity
         *  */

        return $response;
    }

    private function getStatValues($period)
    {
        /*
         *$response['from']          = $period['from'];
          $response['to']            = $period['to'];
        */
        $response['finalMarks'] = GetInfoForGraficTrait::getInfoForGraphics($period, 1);
        $response['ownMarks']   = GetInfoForGraficTrait::getInfoForGraphics($period, 2);
        if(count($response['finalMarks']) > 0){
            foreach($response['finalMarks'] as $index =>$obj){
                array_push($response['finalMarks'],Carbon::createFromFormat('Y-m-d' , $obj->date)->timestamp . "000",
                            $obj->final_estimation);
                unset($response['finalMarks'][$index]);
            }
        }
        if(count($response['ownMarks']) > 0){
            foreach ($response['ownMarks'] as $index => $obj){
                array_push($response['ownMarks'], Carbon::createFromFormat('Y-m-d' , $obj->date)->timestamp."000", 
                            $obj->own_estimation);//$obj->date
                unset($response['ownMarks'][$index]);
            }
        }
        //dd($response);

        return $response;
    }
}
