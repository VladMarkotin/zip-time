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

    public function getUsersInTimezone()     //  get all the users in a specific Timezone
    {
        $currentTimezone = [];
        $timezones = $this->getUniqueTimezones();
        foreach ($timezones as $timezone) {
            $time = Carbon::now($timezone);    
            if ($time->hour === 23) {
                array_push($currentTimezone, $time->getTimezone());   // if hour in that timezone == 23:59(end of day) push user to array
            }
        }

        $currentTimezone == []
            ? ($currentTimezone = null)
            : ($currentTimezone = $currentTimezone);    // if no timezones in Db at 23:59 return null
        $users = User::where('timezone', $currentTimezone)
            ->pluck('id')
            ->toArray();
        //dd($currentTimezone, $users);
        return $users;
    }
}
