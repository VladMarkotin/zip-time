<?php
/**
 * Created by PhpStorm.
 * User: Vlad
 * Date: 26.11.2021
 * Time: 15:45
 */
namespace App\Repositories\StatRepositories;


use App\Repositories\StatRepositories\traits\AverageMarkTrait;

class StatRepository
{
    public function getStat(array $data)
    {
        $response = [];
        switch(isset($data['date']) ){
            case true:
                $response = $this->getStatForPeriod($data['date']);
                break;
            case false:
                $response = $this->getStatForPeriod($data);
                break;
        }

        return $response;
    }

    private function getStatForPeriod($period)
    {
        /*Get stat for the period. Stat means: AVG mark, AVG personal mark, Max Mark, Min Mark, Median Mark*/
        $response['from']          = $period['from'];
        $response['to']            = $period['to'];
        $response['avgMark']       = AverageMarkTrait::getAvgMark($period, 1);
        $response['ownAvgMark']    = AverageMarkTrait::getAvgMark($period, 2);
        $response['medianMark']    = AverageMarkTrait::getMedianValue($period);
        $response['medianOwnMark'] = AverageMarkTrait::getMedianValue($period, 2);
        $response['maxMark']       = AverageMarkTrait::getExtremum($period);
        $response['minMark']       = AverageMarkTrait::getExtremum($period, 2);

        return $response;
    }
}
