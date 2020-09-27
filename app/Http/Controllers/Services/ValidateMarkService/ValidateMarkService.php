<?php
/**
 * Created by PhpStorm.
 * User: Vlad
 * Date: 26.07.2020
 * Time: 11:16
 */
namespace App\Http\Controllers\Services\ValidateMarkService;


use Illuminate\Support\Facades\Validator as Validator;

class ValidateMarkService {

    public function validate(array $data)
    {
        $sliceData = $this->chunkData($data);
        $answers = [];
        $answers[] = $this->areAllMarksValid($sliceData);
        $answers[] = $this->areAllNotesValid($sliceData);
        foreach($answers as $a){
            if(is_object($a) ){
                return $a;
            }
        }

        return true;
    }

    private function areAllMarksValid($data)
    {

        foreach($data as $i => $v){
            if($v[0] == "on"){
                //die(print_r($data));
                $validator = Validator::make(
                    $v,
                    [
                        '0' => 'bool|accepted', //|accepted
                    ]
                );
                if ($validator->fails()) {
                    $v[0] = 50;
                }else{
                    $v[0] = 99;
                }
            }
            $validator = Validator::make(
                $v,
                [
                    '0' => 'numeric|nullable|min:50|max:100', //|accepted
                ]
            );
            if ($validator->fails()) {
                return $validator->errors();
            }
        }

        return true;
    }

    private function areAllNotesValid($data)
    {
        $validator = Validator::make(
            $data,
            [
                '*.1' => 'max:255|nullable'
            ]
        );
        if($validator->fails()){
            return $validator->errors();
        }

        return true;
    }

    private function chunkData(array $data)
    {
        $divider = (count($data) >= 2) ? count($data): 1; //

        return list($array1, $array2) = array_chunk($data, ceil(count($data) / ( $divider/3 )) );
    }
} 