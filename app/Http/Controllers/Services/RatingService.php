<?php

/**
 * Created by PhpStorm.
 * User: francis
 * Date: 08.10.2022
 * Time: 8:30
 */










 //сhange formalar and fix rb for combuter


namespace App\Http\Controllers\Services;

use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class RatingService
{
    private $Ra; // 100 by default
    private $Rb = 1000; // 1000 by default
    private $Sa;
    public $newRating;
    public $dayStatus;

    public function rateCompletedDay($dayStatus)
    {
       
        //  get rating when close day button is clicked by d user
        $array = $this->setKCoefficient();
        $k = $array[0];
        $rb = $array[1];
       $newRating = $this->estimateRating($dayStatus, $k, $rb);
        $user = User::where('id', Auth::id())->first();
        if ($user->rating > 0) {
            $user->rating += $newRating;
            $user->update();
       }
    }

    public function estimateActiveDayrating($dayStatus)
    {
       
        //  get day rating for users with an uncompleted plan by cron script at day end
        $usersUnder30Days  = [];
        $usersAbove180Days = [];
        $usersBtw30_90Days = [];
        $usersBtw90_180Days= [];

        $activeUsers = $this->idsToBeRated();

        foreach ($activeUsers as $users => $days) {
            if ($days <= 30) {
                $k = 40; $rb = 20;
                $usersUnder30Days[] = $users;
                $newRating = $this->estimateRating($dayStatus, $k, $rb);
                $users = User::whereIn('id', $usersUnder30Days)->get();
                $this->saveToDB($users, $newRating);
            }
            if ($days > 30 && $days < 90) {
                $k = 20; $rb = 15;
                $usersBtw30_90Days[] = $users;
                $newRating = $this->estimateRating($dayStatus, $k, $rb);
                $users = User::whereIn('id', $usersBtw30_90Days)->get();
                $this->saveToDB($users, $newRating);
            }

            if ($days >= 90 && $days < 180) {
                $k = 10; $rb = 10;
                $usersBtw90_180Days[] = $users;
                $newRating = $this->estimateRating($dayStatus, $k, $rb);
                $users = User::whereIn('id', $usersBtw90_180Days)->get();
                $this->saveToDB($users, $newRating);
            }
            if ($days > 180) {
                $k = 5; $rb = 5;
                $usersAbove180Days[] = $users;
                $newRating = $this->estimateRating($dayStatus, $k, $rb);
                $users = User::whereIn('id', $usersAbove180Days)->get();
                $this->saveToDB($users, $newRating);
            }
        }
    }

    public function estimateLazyDayrating($dayStatus)
    {
     
        //  get day rating for lazy users without a plan by cron script at day end
        $userUnder30Days  = [];
        $userAbove180Days = [];
        $userBtw30_90Days = [];
        $userBtw90_180Days= [];

        $lazyUsers = $this->getBadIds();
        

        foreach ($lazyUsers as $users => $days) {
            if ($days <= 30) {
                $k = 40; $rb = 20;
                $userUnder30Days[] = $users;
                $newRating = $this->estimateRating($dayStatus, $k, $rb);
                $users = User::whereIn('id', $userUnder30Days)->get();
                $this->saveToDB($users, $newRating);
            }

            if ($days > 30 && $days < 90) {
                $k = 20; $rb = 15;
                $userBtw30_90Days[] = $users;
                $newRating = $this->estimateRating($dayStatus, $k, $rb);
                $users = User::whereIn('id', $userBtw30_90Days)->get();
                $this->saveToDB($users, $newRating);
            }

            if ($days >= 90 && $days < 180) {
                $k = 10; $rb = 10;
                $userBtw90_180Days[] = $users;
                $newRating = $this->estimateRating($dayStatus, $k, $rb);
                $users = User::whereIn('id', $userBtw90_180Days)->get();
                $this->saveToDB($users, $newRating);
            }

            if ($days > 180) {
                $k = 5; $rb = 5;
                $userAbove180Days[] = $users;
                $newRating = $this->estimateRating($dayStatus, $k, $rb);
                $users = User::whereIn('id', $userAbove180Days)->get();
                $this->saveToDB($users, $newRating);
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
        // set K for logged in user
        if ($this->userSinceInDays() <= 30) {
            $k = 40; $rb = 20;
        } elseif (
            $this->userSinceInDays() > 30 &&
            $this->userSinceInDays() < 90
        ) {
            $k = 20; $rb = 15;
        } elseif (
            $this->userSinceInDays() > 90 &&
            $this->userSinceInDays() < 180
        ) {
            $k = 10; $rb = 10;
        } else {
            $k = 5; $rb = 5;
        }
        return [$k, $rb];
    }

    private function estimateRating($dayStatus, $k, $rb)
    {
        // rating clculator
        $Ea = 1 / (1 + pow(10 , (($this->Rb + $rb) - $this->Ra) / 400));

        switch ($dayStatus) {
            case 2: // completed day status
                $this->Sa = 1;
                $newRating = $this->Ra + $k * ($this->Sa - $Ea); //  Sa = 1  день успешно закрыт(пользователь)
                break;

            case 1: // 'weekend'
                $this->Sa = 0.5;
                $newRating = $this->Ra + $k * ( $this->Sa- $Ea); //  Sa = 0.5  двзят выходной (пользователь)

                break;

            case 0: // wasted day:
                $this->Sa = 0;
                $newRating = $this->Ra + $k * ($this->Sa - $Ea); //  Sa = 0  день день провален (пользователь)

                break;

            default:
                echo 'day not set';
                break;
        }

        return $newRating;
    }

    private function idsToBeRated()
    {
        //  get all unrated users from timetable .
        $today = Carbon::today()->toDateString();

        $query =
            "SELECT users.id  FROM users JOIN timetables ON users.id = timetables.user_id 
                                     WHERE timetables.day_status = 2 
                                         OR  timetables.day_status = 1 
                                             OR   timetables.day_status = -1 
                                                 AND  timetables.date = '" .
            $today .
            "'";

        $idsArr = DB::select($query); //Array of all user`s id
        $ids = [];
        foreach ($idsArr as $v) {
            $ids[] = $v->id;
        }
        $idsToBeRated = [];
        $now = Carbon::now();
        $users = User::whereIn('id', $ids)->get();
        foreach ($users as $user) {
            $idsToBeRated[$user->id] = $user->created_at->diff($now)->days;
        }

        return $idsToBeRated;
    }

    private function getBadIds()
    {
        // get lazy guys without a day plan
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

        $idsToBeRated = [];
        $now = Carbon::now();
        $users = User::whereIn('id', $badIds)->get();
        foreach ($users as $user) {
            $idsToBeRated[$user->id] = $user->created_at->diff($now)->days;
        }

        return $idsToBeRated;
    }

    private function saveToDB($users, $newRating)
    {
       
       // dd(floor($newRating));
        foreach ($users as $user) {
            if ($user->rating > 0) {
                $user->rating += $newRating;
                $user->update();
            }
        }
    }
}
