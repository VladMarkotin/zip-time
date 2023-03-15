<?php
namespace App\Repositories;

use Auth;
use App\Models\User;
use Illuminate\Support\Carbon;

class TimezoneRepository
{
    private function getUniqueTimezones()
    {
        $timezones = User::distinct('timezone')->pluck('timezone'); // the unique timezones in database
        return $timezones;
    }

    public function getUsersInTimezone()
    {
        $currentTimezone = [];
        $timezones = $this->getUniqueTimezones();
        foreach ($timezones as $timezone) {
            $date = Carbon::now($timezone);
            if ($date->hour === 11) {
                array_push($currentTimezone, $date->getTimezone());
            }
        }

        $users = User::where('timezone', $currentTimezone)->pluck('id')->toArray();
        //dd( $users);
        return $users;
    }
}
