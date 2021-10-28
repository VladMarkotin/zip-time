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
        $makeCommentValid = function () use ($data){
            $data['comment'] = htmlspecialchars($data['comment']);
            if(strlen($data['comment']) > 65535){ //max size of type text in mysql
                $diff = strlen($data['comment']) - 65535;
                $data['comment'] = substr($data['comment'], 0, -$diff);
            }
            else if(strlen($data['comment']) < 5 && ($data['action'] == 0)){
                $data['comment'] = "You have activated emergency call with no explanation! We hope everything is good.";
            }

            return $data;
        };
        switch($data['action']){
            case 1: //user wants to finish day plan
                $data = $makeMarkValid();
                $data = $makeCommentValid();

                return $data;
            case 0:
                $data = $makeCommentValid();

                return $data;
            case -1:
                break;
        }

        return false;
    }
} 