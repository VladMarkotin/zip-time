<?php
/**
 * Created by PhpStorm.
 * User: Vlad
 * Date: 22.08.2021
 * Time: 14:04
 */

namespace App\Http\Controllers\Services;

use App\Repositories\DayPlanRepositories\GetPlanRepository;
class GetDayPlanService
{
    private $dayPlanRepository = null;

    public function __construct(GetPlanRepository $getPlanRepository)
    {
        $this->dayPlanRepository = $getPlanRepository;
    }

    public function getPlan(array $data)
    {
        $response = $this->dayPlanRepository->getLastDayPlan($data);

        return $response;
    }
} 