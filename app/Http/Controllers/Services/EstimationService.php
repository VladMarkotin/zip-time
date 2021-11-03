<?php
/**
 * Created by PhpStorm.
 * User: Vlad
 * Date: 28.10.2021
 * Time: 8:45
 */

namespace App\Http\Controllers\Services;


class EstimationService
{
    /**
     * @param array $data
     * @return bool
     * I have to check own_mark and comment
     */
    public function handleEstimationRequest(array $data)
    {
        $makeMarkValid = function () use  ($data) {
            if( ($data['own_mark'] < 0) ) {
                $data['own_mark'] = 0;
            } else if(($data['own_mark'] > 100)){
                $data['own_mark'] = 100;
            }

            return $data;
        };
        $makeCommentValid = function ($data) use ($data){
            $data = htmlspecialchars($data);
            if(strlen($data) > 65535){ //max size of type text in mysql
                $diff = strlen($data) - 65535;
                $data = substr($data, 0, -$diff);
            }
            else if(strlen($data) < 5 && ($data['action'] == 0)){
                $data['comment'] = "You have activated emergency call with no explanation! We hope everything is good.";
            }

            return $data;
        };
        $makeNoteValid    = function () use ($data){
            $data['note'] = (isset($data['note'])) ? $data['note'] : '';
            $data['note'] = htmlspecialchars($data['note']);
            if(strlen($data["note"]) > 255){
                $diff = strlen($data['note']) - 255;
                $data['note'] = substr($data['comment'], 0, -$diff);
            }

            return $data;
        };
        switch($data['action']){
            case '2': //user wants to finish day plan
                $data = $makeMarkValid($data['mark']);
                $data = $makeCommentValid($data['comment']);

                return $data;
            case '1': //for estimation of task?tasks
                $data['note'] = $makeNoteValid();
                break;
            case '0': //for emergency
                $data = $makeCommentValid();

                return $data;
            /*case -1:
                break;*/
        }

        return false;
    }
} 