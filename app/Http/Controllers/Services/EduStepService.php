<?php
/**
 * Created by PhpStorm.
 * User: Vlad
 * Date: 28.10.2021
 * Time: 8:45
 */

namespace App\Http\Controllers\Services;


use App\Models\User;
use Auth;

class EduStepService
{
    private $user = null;     

    public function getPresentstionStep()
    {
        $presentationStep = User::where('id', Auth::id())->pluck('edu_step')->toArray();

        return $presentationStep;
    }
   
} 