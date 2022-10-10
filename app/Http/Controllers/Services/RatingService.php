<?php

/**
 * Created by PhpStorm.
 * User: francis
 * Date: 08.10.2022
 * Time: 8:30
 */

namespace App\Http\Controllers\Services;

use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Repositories\EstimationRepository;

class RatingService
{
    private $Ra; // 100 by default
    private $Rb = 1000; // 1000 by default
    private $Ea;
    private $Eb;
    private $Sa;
    public $NRa;
    public $NRb;
    public $dayStatus;

    public function rateCompletedDay($dayStatus)  //  get rating when close day button is clicked
    {
        $newRating = $this->estimateRating($dayStatus);
        $completedDayIds = $this->getCompletedDayIds();
        if (count($completedDayIds) != 0) {
            $users = User::whereIn('id', $completedDayIds)->get();
            foreach ($users as $user) {
               
                if(  $user->rating > 0 )
                {
                    $user->rating += $newRating;
                    $user->update();  
                }
                
            }
        }
    }

    public function rateCompletedDayAuto($dayStatus)  //  get rating when shedule script runs.
    {
        $newRating = $this->estimateRating($dayStatus);

        $ids = $this->getIds();
        $weekendIds = $this->getWeekendIds();
        $badIds = $this->getBadIds();
        // var_dump($ids);
        // var_dump($weekendIds);
        // var_dump($badIds);

        if (count($ids) != 0) {
            $users = User::whereIn('id', $ids)->get();
            foreach ($users as $user) {
                if(  $user->rating > 0 )
                {
                $user->rating += $newRating;
                $user->update();
                }
            }
        }

        if (count($badIds) != 0) {
            $users = User::whereIn('id', $badIds)->get();
            foreach ($users as $user) {
                if(  $user->rating > 0 )
                {
                $user->rating += $newRating;
                $user->update();
                }
            }
        }

        if (count($weekendIds) > 0) {
            $users = User::whereIn('id', $weekendIds)->get();
            foreach ($users as $user) {
                if(  $user->rating > 0 )
                {
                $user->rating += $newRating;
                $user->update();
                }
            }
        }
    }

    private function userSinceInDays()
    {
        if (Auth::check()) {
            $created = User::where('id', Auth::id())
                ->pluck('created_at')
                ->first();
            $now = Carbon::now();
            $difference = $created->diff($now)->days;
        }
        return $difference;
    }

    private function setKCoefficient()
    {
        if ($this->userSinceInDays() <= 30) {
            $k = 40;
        } elseif (
            $this->userSinceInDays() > 30 &&
            $this->userSinceInDays() < 90
        ) {
            $k = 20;
        } elseif (
            $this->userSinceInDays() > 90 &&
            $this->userSinceInDays() < 180
        ) {
            $k = 10;
        } else {
            $k = 5;
        }
        return $k;
    }

    private function estimateRating($dayStatus)
    {
        $Ea = 1 / ((1 + 10) ^ (($this->Rb - $this->Ra) / 400));

        switch ($dayStatus) {
            case 2: // completed day status
                $this->Sa = 1;
                $NRa = $this->Ra + $this->setKCoefficient() * ($this->Sa - $Ea); //  Sa = 1  день успешно закрыт(пользователь)
                break;

            case 1: // 'weekend'
                $this->Sa = 0.5;
                $NRa = $this->Ra + $this->setKCoefficient() * ($this->Sa - $Ea); //  Sa = 0.5  двзят выходной (пользователь)

                break;

            case 0: // wasted day:
                $this->Sa = 0;
                $NRa = $this->Ra + $this->setKCoefficient() * ($this->Sa - $Ea); //  Sa = 0  день день провален (пользователь)

                break;

            default:
                echo 'day not set';
                break;
        }

        // $result = [
        //     $this->Ra,
        //     $NRa,
        //     $this->NRb,
        //     $this->setKCoefficient(),
        //     $this->userSinceInDays(),
        //     $this->Sa,
        // ];

        return $NRa;
    }

    private function getBadIds()
    {
        $today = Carbon::today()->toDateString();
        $query =
            "SELECT users.id FROM users WHERE
                        users.id NOT IN (select b.user_id
                            from timetables b
                               where b.date = '" .
            $today .
            "');
                        ";
        //dd($query);
        $idsArr = DB::select($query); //Array of all user`s id
        $badIds = [];
        foreach ($idsArr as $v) {
            $badIds[] = $v->id;
        }

        return $badIds;
    }

    private function getWeekendIds()
    {
        $today = Carbon::today()->toDateString();
        $query =
            "SELECT users.id FROM users JOIN timetables ON users.id = timetables.user_id
                         WHERE timetables.day_status = 1
                         AND timetables.own_estimation = 0
                         AND timetables.date = '" .
            $today .
            "'";
        $idsArr = DB::select($query); //Array of all user`s id
        $ids = [];
        foreach ($idsArr as $v) {
            $ids[] = $v->id;
        }

        return $ids;
    }

    private function getIds()
    {
        $today = Carbon::today()->toDateString();

        $query =
            "SELECT users.id FROM users JOIN timetables ON users.id = timetables.user_id WHERE
                        timetables.day_status = 2 AND
                        timetables.date = '" .
            $today .
            "'";
        $idsArr = DB::select($query); //Array of all user`s id
        $ids = [];
        foreach ($idsArr as $v) {
            $ids[] = $v->id;
        }

        return $ids;
    }

    private function getCompletedDayIds()
    {
        $today = Carbon::today()->toDateString();

        $query =
            "SELECT users.id FROM users JOIN timetables ON users.id = timetables.user_id WHERE
                        timetables.day_status = 3 OR  timetables.day_status = 1 AND
                        timetables.date = '" .
            $today .
            "'";
        $idsArr = DB::select($query); //Array of all user`s id
        $ids = [];
        foreach ($idsArr as $v) {
            $ids[] = $v->id;
        }

        return $ids;
    }
}
