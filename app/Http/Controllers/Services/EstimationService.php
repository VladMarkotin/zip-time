<?php
/**
 * Created by PhpStorm.
 * User: Vlad
 * Date: 28.10.2021
 * Time: 8:45
 */

namespace App\Http\Controllers\Services;


use App\Repositories\EstimateTaskRepository;
use App\Repositories\EstimationRepository;

class EstimationService
{
    private $estimateTaskRepository = null;
    private $estimateDayRepository  = null;

    public function __construct(EstimateTaskRepository $estimateTaskRepository,
                                EstimationRepository $estimationRepository)
    {
        $this->estimateTaskRepository = $estimateTaskRepository;
        $this->estimateDayRepository  = $estimationRepository;
    }
    /**
     * @param array $data
     * @return bool
     * I have to check own_mark and comment
     */
    public function handleEstimationRequest(array $data)
    {
        $makeMarkValid    = function ($arg = null) use  ($data) {
            if($data['mark'] == '') {
               $data['mark'] = -1;
            }
            if($data['mark'] == '0') {
                $data['mark'] = -1;
            }
            $data['mark'] = intval($data['mark']);
            if(is_int($data['mark'])){
                if(!$arg) {
                    if (($data['mark'] < 50 && $data['mark'] != 0 && ($data['mark'] != -1))) {
                        $data['mark'] = -1;
                        return false;
                    } else if (($data['mark'] > 99)) {
                        $data['mark'] = -1;
                        return false;
                    } else if($data['mark']  === 0){
                        $data['mark'] = -1;
                        return false;
                    } else if($data['mark']  == -1){
                        $data['mark'] = -1;
                        
                        return $data['mark'];
                    }
                } else{
                    if (($data['mark'] < 1)) {
                        $data['mark'] = 1;
                    } else if (($data['mark'] > 200)) {
                        $data['mark'] = 200;
                    }
                }

                return $data['mark'];
            }else{
                return false;
            }

            return false;
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

            return $data['comment'];
        };
        $makeNoteValid    = function () use ($data){
            $data['note'] = (isset($data['note'])) ? $data['note'] : '';
            $data['note'] = htmlspecialchars($data['note']);
            if(strlen($data["note"]) > 255){
                $diff = strlen($data['note']) - 255;
                $data['note'] = substr($data['note'], 0, -$diff);
            }
            //die(var_dump($data['note']));
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
        $isTaskReady = function () use ($data){
            $data['is_ready'] = intval($data['is_ready']);
        };
        switch($data['action']){

            case '2': //user wants to finish day plan
                $data['mark'] = $makeMarkValid(2); //it means that user gives an own mark for checking
                $data['comment'] = $makeCommentValid($data['comment']);
                $response = $this->estimateDayRepository->closeDay($data);
                if($response){
                    return ["status" => "success", "message" => "Your day plan is completed :) Good work!"];
                }

                return ["status" => "error", "message" => "Your day plan hasn`t been done yet. You still have some
                         required jobs/tasks incomplete! "];
            case '1': //for estimation of job & task
                if(!$data['mark'] && ($data['is_ready'])){
                    $data['mark'] = $data['is_ready'];
                }
                $data['mark']     = $makeMarkValid();
                $data['note']     = $makeNoteValid();
                $data['details']  = $makeDetailsValid();
                if($data['mark'] !== false){
                    $response = $this->estimateTaskRepository->estimateTask($data);
                    unset($data['action']);
                    if($response === true){
                        return $data;
                    }
                }

                return false;
            case '0': //for emergency
                $data = $makeCommentValid();

                return $data;
            case '3':
                $data['note']    = $makeNoteValid();
                $data['details'] = $makeDetailsValid();

                return $data;
        }

        return false;
    }
} 