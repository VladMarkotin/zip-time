<?php

namespace App\Http\Controllers\Services;

use Illuminate\Support\Facades\Auth;
use App\Models\User;

class GetUserTimeService
{
    public function getUserTime($format) 
    {
        $currentUserTimeZone = User::select(['timezone'])
        ->where('id', Auth::id())
        ->get()
        ->toArray();

        if (count($currentUserTimeZone)) {
            $currentUserTimeZone = $currentUserTimeZone[0]['timezone'];
            date_default_timezone_set($currentUserTimeZone);
            $userTime = date($format);
            date_default_timezone_set('Europe/Minsk');
            
            return $userTime;
        }
    }
} 