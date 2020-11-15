<?php
/**
 * Created by PhpStorm.
 * User: Vlad
 * Date: 08.09.2020
 * Time: 14:13
 */

namespace Controllers\Services\PlanServices;


use App\Repositories\DayInfoRepository;

class EmergencyCallService
{
    private $dayInfoRepository = null;

    public function __construct(DayInfoRepository $dayInfoRepository)
    {
        $this->dayInfoRepository = $dayInfoRepository;
    }

    public function emergencyCall($data)
    {
        /*
         * Array
                (
                    [cause] => fghrfh
                )
        */
        $request = [
            "status"   => 'экстрен',
            "comment"  => $data['cause']
        ];
        $response = $this->dayInfoRepository->updateDayStatus($request);

        return $response;
    }
} 