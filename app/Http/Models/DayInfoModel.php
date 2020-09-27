<?php

namespace Models;

use Illuminate\Database\Eloquent\Model;

class DayInfoModel extends Model
{
    protected $table = "timetables";
    protected $user_id;
    protected $date;
    protected $day_status;
    protected $final_estimation;
    protected $own_estimation;
    protected $comment;
    protected $necessary;
    protected $forTomorrow;
    protected $cause;

    /**
     * @return mixed
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param mixed $comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getDayStatus()
    {
        return $this->dayStatus;
    }

    /**
     * @param mixed $dayStatus
     */
    public function setDayStatus($dayStatus)
    {
        $this->day_status = $dayStatus;
    }

    /**
     * @return mixed
     */
    public function getFinalEstimation()
    {
        return $this->finalEstimation;
    }

    /**
     * @param mixed $finalEstimation
     */
    public function setFinalEstimation($finalEstimation)
    {
        $this->finalEstimation = $finalEstimation;
    }

    /**
     * @return mixed
     */
    public function getForTomorrow()
    {
        return $this->forTomorrow;
    }

    /**
     * @param mixed $forTomorrow
     */
    public function setForTomorrow($forTomorrow)
    {
        $this->forTomorrow = $forTomorrow;
    }

    /**
     * @return mixed
     */
    public function getNecessary()
    {
        return $this->necessary;
    }

    /**
     * @param mixed $necessary
     */
    public function setNecessary($necessary)
    {
        $this->necessary = $necessary;
    }

    /**
     * @return mixed
     */
    public function getOwnEstimation()
    {
        return $this->ownEstimation;
    }

    /**
     * @param mixed $ownEstimation
     */
    public function setOwnEstimation($ownEstimation)
    {
        $this->ownEstimation = $ownEstimation;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param mixed $user_id
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * @param mixed $cause
     */
    public function setCause($cause)
    {
        $this->cause = $cause;
    }


}
