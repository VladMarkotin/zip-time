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

class HashCodeService
{
    private $savedTaskRepository = null;
    private $dataForTransformForDb = [
        'type' => [
            'required job'     => 4,
            'non required job' => 3,
            'required task'    => 2,
            'task'             => 1,
            'reminder'         => 0,
        ],
    ];

    public function __construct(SavedTask2Repository $savedTask2Repository)
    {
        $this->savedTaskRepository = $savedTask2Repository;
    }

    public function checkNewHashCode($hashCode)
    {
        if($this->isHashCodeCorrect($hashCode)){
            if($this->isUniqueForUser($hashCode)){
                return true;
            }
        }

        return false;
    }

    public function transformDataForDb($data)
    {
        $dataForDb = $data;
        $dataForDb['type'] = $this->dataForTransformForDb['type'][$dataForDb['type']];

        return $dataForDb;
    }

    private function isUniqueForUser($hashCode)
    {
        $hashCodes = $this->savedTaskRepository->getUserHashCodes(Auth::id());

        foreach($hashCodes as $i){
            if($i->hash_code == $hashCode){
                return false;
            }
        }

        return true;
    }

    private function isHashCodeCorrect($hashCode)
    {
        $length = strlen($hashCode);
        if(($length < 7) && ($length > 1)){
            return true;
        }

        return false;
    }
}
