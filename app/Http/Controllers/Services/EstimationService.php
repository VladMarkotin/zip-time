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
            if( ($data['mark'] < 50) ) {
                $data['mark'] = 50;
            } else if(($data['mark'] > 99)){
                $data['mark'] = 99;
            }

            return $data['mark'];
        };
        $makeCommentValid = function () use ($data){
            $data['comment'] = htmlspecialchars($data['comment']);
            if(strlen($data['comment']) > 65535){ //max size of type text in mysql
                $diff = strlen($data['comment']) - 65535;
                $data['comment'] = substr($data['comment'], 0, -$diff);
            }
            else if(strlen($data) < 5 && ($data['action'] == 0)){
                $data['comment'] = "You have activated emergency call with no explanation! We hope everything is good.";
            }

            return $data['comment'];
        };
        $makeNoteValid    = function () use ($data){
            $data['note'] = (isset($data['note'])) ? $data['note'] : '';
            $data['note'] = htmlspecialchars($data['note']);
            if(strlen($data["note"]) > 255){
                $diff = strlen($data['note']) - 255;
                $data['note'] = substr($data['comment'], 0, -$diff);
            }

            return $data['note'];
        };
        $makeDetailsValid = function () use ($data){
            $data['details'] = htmlspecialchars($data['details']);
            if(strlen($data['details']) > 65535){ //max size of type text in mysql
                $diff = strlen($data['details']) - 65535;
                $data['details'] = substr($data['details'], 0, -$diff);
            }

            return $data['details'];
        };
        switch($data['action']){
            case '2': //user wants to finish day plan
                $data = $makeMarkValid($data['mark']);
                $data = $makeCommentValid($data['comment']);

                return $data;
            case '1': //for estimation of task
                $data['mark']    = $makeMarkValid();
                $data['note']    = $makeNoteValid();
                $data['details'] = $makeDetailsValid();
                unset($data['action']);

                return $data;
            case '0': //for emergency
                $data = $makeCommentValid();

                return $data;
            /*case -1:
                break;*/
        }

        return false;
    }
} 