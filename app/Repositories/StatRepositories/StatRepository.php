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
        $response['from']          = $period['from'];
        $response['to']            = $period['to'];
        $response['totalTime']     = AverageMarkTrait::getTotalTime($period);
        $response['avgMark']       = AverageMarkTrait::getAvgMark($period, 1);
        $response['ownAvgMark']    = AverageMarkTrait::getAvgMark($period, 2);
        $response['medianMark']    = AverageMarkTrait::getMedianValue($period);
        $response['medianOwnMark'] = AverageMarkTrait::getMedianValue($period, 2);
        $response['maxMark']       = AverageMarkTrait::getExtremum($period);
        $response['minMark']       = AverageMarkTrait::getExtremum($period, 2);

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
                $response['finalMarks'][$obj->date] = $obj->final_estimation;
                unset($response['finalMarks'][$index]);
            }
        }
        if(count($response['ownMarks']) > 0){
            foreach ($response['ownMarks'] as $index => $obj){
                $response['ownMarks'][$obj->date] = $obj->own_estimation;
                unset($response['ownMarks'][$index]);
            }
        }

        return $response;
    }
}
