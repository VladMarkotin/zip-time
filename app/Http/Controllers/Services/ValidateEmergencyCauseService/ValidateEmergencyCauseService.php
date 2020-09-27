<?php
/**
 * Created by PhpStorm.
 * User: Vlad
 * Date: 07.09.2020
 * Time: 13:41
 */
namespace App\Http\Controllers\Services\ValidateEmergencyCauseService;


use Illuminate\Validation\Validator;

class ValidateEmergencyCauseService
{
    private $answers = [];

    public function check($data)
    {
        $this->answers[] = $this->checkCauseLength($data['cause']);

        return $this->answers;
    }

    private function checkCauseLength($data)
    {
        if(strlen($data) > 5){
            return 1;
        }

        return 0;
    }
} 