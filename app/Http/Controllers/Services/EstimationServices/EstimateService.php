<?php
/**
 * Created by PhpStorm.
 * User: Vlad
 * Date: 28.07.2020
 * Time: 14:44
 */
namespace App\Http\Controllers\Services\EstimationServices;

use App\Repositories\DayInfoRepository;
use App\Repositories\TaskRepository;


class EstimateService
{
    private $taskRepository    = null;
    private $dayInfoRepository = null;

    public function __construct(TaskRepository $taskRepository,
                                DayInfoRepository $dayInfoRepository)
    {
        $this->taskRepository    = $taskRepository;
        $this->dayInfoRepository = $dayInfoRepository;
    }

    public function estimate(array $estimationArray)
    {
        $chunkEstimationArray = $this->chunkData($estimationArray);
        //die(print_r($chunkEstimationArray)); то что надо (как минимум если у меня 2 задания)
        $lastTimetableId = $this->dayInfoRepository->lastTimetable();
        $this->taskRepository->updateById($lastTimetableId, $chunkEstimationArray);

    }

    private function chunkData(array $data)
    {
        $divider = (count($data) >= 3) ? count($data): 1; //

        return list($array1, $array2) = array_chunk($data, ceil(count($data) / ( $divider/3 )) );
    }
} 