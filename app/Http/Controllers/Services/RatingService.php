<?php

/**
 * Created by PhpStorm.
 * User: francis
 * Date: 08.10.2022
 * Time: 8:30
 */

namespace App\Http\Controllers\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RatingService
{
    private $Ra = 100;
    private $Rb = 1000;
    private $Ea;
    private $Eb;
    public $dayStatus;
    public $NRa;
    public $NRb;

    private function saveUserRtingToDB($newRating)
    {
        $user = User::find(Auth::id());
        if ($user) {
            $user->rating += $newRating;
            $user->update();
        }
    }

    public function getUserRatings($dayStatus)
    {

        // set K coefficient
        
        $this->dayStatus = $dayStatus;
        switch ($this->NRa) {
            case $this->NRa > 100:
                $k = 10;
                break;
            case $this->NRa < 100:
                $k = 20;
                break;
            case 'new users':
                $k = 40;
                break;
            default:
                $k = 10;
        }

        $Ea = 1 / ((1 + 10) ^ (($this->Ra - $this->Rb) / 400));

        // $Eb = 1/(1+10^(($this -> Ra - $this -> Rb)/400));

        if ($this->dayStatus == 'completed') {
            $this->NRa = $this->NRa + ($this->Ra + $k * (1 - $Ea)); //  Sa = 1  день успешно закрыт(пользователь)
            //$this->NRb=$this->Rb - $k($this -> 0 - $Eb);(приложения)
            $this->saveUserRtingToDB($this->NRa);


        } elseif ($this->dayStatus == 'weekend') {
            $this->NRa = $this->Ra + $k * (0.5 - $Ea); //  Sa = 0.5  двзят выходной (пользователь)
            //$this->NRb=$this->Rb - $k($this -> 0.5 - $Eb);(приложения)
            $this->saveUserRtingToDB($this->NRa);

            
        } elseif ($this->dayStatus == 'wasted day') {
            $this->NRa = $this->Ra + $k * (0 - $Ea); //  Sa = 0  день день провален (пользователь)
            //$this->NRb=$this->Rb - $k($this -> 1 - $Eb); (приложения)
            $this->saveUserRtingToDB($this->NRa);
        }

        $result = [$this->NRa, $this->NRb];
        return $result;
    }
}
