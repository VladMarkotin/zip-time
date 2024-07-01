<?php
/**
 * Created by PhpStorm.
 * User: Vlad
 * Date: 29.05.2021
 * Time: 8:30
 */
namespace App\Http\Controllers\Services;

use App\Repositories\SavedTask2Repository;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Services\AddPlanService;

class HashCodeService
{
    private $savedTaskRepository   = null;
    private $dataForTransformForDb = [
        'type' => [
            'required job'     => 4,
            'non required job' => 3,
            'required task'    => 2,
            'task'             => 1,
            'reminder'         => 0,
        ],
    ];
    private $addPlanService       = null;

    public function __construct(SavedTask2Repository $savedTask2Repository, AddPlanService $addPlanService)
    {
        $this->savedTaskRepository = $savedTask2Repository;
        $this->addPlanService      = $addPlanService;
    }

    public function checkNewHashCode($hashCode, $taskName)
    {   
        $resOfChecks = [
            $this->isHashCodeCorrect($hashCode),
            $this->addPlanService->checkName($taskName),
            $this->isUniqueForUser($hashCode)
        ];

        foreach($resOfChecks as $result) {
            if ($result['flag'] === false) {
                return $result;
            }
        }

        return ["flag" => true, 'message' => 'Hash code added successfully',];
    }

    public function transformDataForDb($data)
    {
        $dataForDb = $data;
        $dataForDb['type'] = $this->dataForTransformForDb['type'][$dataForDb['type']];

        return $dataForDb;
    }

    private function isUniqueForUser($hashCode)
    {
        $hashCodes = $this->savedTaskRepository->getUserHashCodes(Auth::id(), 0);

        foreach($hashCodes as $i){
            if($i->hash_code == $hashCode){
                return ['flag' => false, 'message' => 'Your code must be unique.'];
            }
        }

        return ['flag' => true];
    }

    private function isHashCodeCorrect($hashCode)
    {
        $length = strlen($hashCode);
        if(($length < 7) && ($length > 1)){
            return ['flag' => true];
        }

        $transformedCode = strlen($hashCode) < 30 ? $hashCode :  substr($hashCode, 0, 29) . '...'; 

        return [
            'flag' => false, 
            'message' => "The name of your code must contain between 2 and 6 characters, inclusive. Unable to use code: $transformedCode"
        ];
    }
}
