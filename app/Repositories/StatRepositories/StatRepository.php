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
        $response['avgMark']    = AverageMarkTrait::getAvgMark($period);
        $response['ownAvgMark'] = AverageMarkTrait::getOwnAvgMark($period);
        $response['medianMark'] = AverageMarkTrait::getMedianValue($period);
        $response['maxMark']    = AverageMarkTrait::getMaxMark($period);
        $response['minMark']    = AverageMarkTrait::getMinMark($period);

        return $response;
    }
} 