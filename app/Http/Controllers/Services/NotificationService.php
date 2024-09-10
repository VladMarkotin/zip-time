<?php
/**
 * Created by PhpStorm.
 * User: Francis
 * Date: 12.05.2024
 * Time: 13:52
 */

namespace App\Http\Controllers\Services;

use Carbon\Carbon;

use App\Models\User;
use Illuminate\Http\Request;
use Minishlink\WebPush\WebPush;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Minishlink\WebPush\Subscription;
use Illuminate\Support\Facades\Log;
use App\Http\Helpers\GeneralHelpers\GeneralHelper;
use App\Http\Helpers\TimeHelpers\TimeHelper;  
use App\Http\Helpers\TimeHelpers\RemindTimeHelper;  

class NotificationService
{
    private $timezoneList = [];

    private $tzList = [
        RemindTimeHelper::MORNING_TIME => ['09'],
        RemindTimeHelper::EVENING_TIME => ['19'],
    ];

    public function __construct()
    {
        $this->tzList[RemindTimeHelper::MORNING_TIME] = TimeHelper::getTimezonesWithTime(RemindTimeHelper::MORNING_TIME);
        $this->tzList[RemindTimeHelper::EVENING_TIME] = TimeHelper::getTimezonesWithTime(RemindTimeHelper::EVENING_TIME);
    }

    public function saveSubscription(Request $request)
    {
    
          User::where('id', Auth::id())
          ->update([
            'device_token'=>$request->sub
        ]);
    }

    public function sendNotification($ids, $message)
    {
     
        $auth = [
            'VAPID' => [
                'subject' => 'https://quipl.co/', // can be a mailto: or your website address
                'publicKey' => '    BGPbvN2N_ETuxiZZ90jMjXWardKtcrhDeFr93npJg5pInkDpDtJfUXRH0Het53h-zNUgRmS30N9iiCM-uN6Jsxk  ', // (recommended) uncompressed public key P-256 encoded in Base64-URL
                'privateKey' => '0Rdr03_bupDraVkmhF6j7q73nlaPyVT-bDtMWW7NLPA', // (recommended) in fact the secret multiplier of the private key encoded in Base64-URL
            ],
        ];

        $webPush = new WebPush($auth);
 
        $payload = json_encode([
            'title' => "Todays Plan Reminder",
            'body' => $message,
            'url' => 'https://quipl.co/',
        ]);

        $notifications = User::whereIn('id', $ids)->get();
        
        foreach ($notifications as $notification) {
            $webPush->sendOneNotification(
                Subscription::create($notification['device_token']),
                $payload,
                ['TTL' => 5000]
            );
        }

    
    }

    
    public function reminder(): void
    {
        $flag = 0;
        foreach ($this->tzList as $time => $zones) {
            if ($time == RemindTimeHelper::EVENING_TIME) {
                $flag = 1;
            }
            
            $this->sendNotification(
                $this->defineNotificationGroup($this->tzList[$time], $flag),
                $this->reminderMessages()[$time]
            );
        }
    }

    public function defineNotificationGroup(array $zones = [], $flag = 0) //0-morning 1-evening
    {
        if (count($zones) > 0) {
            $timezones = GeneralHelper::prepareSqlIn($zones);
            $today = Carbon::today()->toDateString();

            if (!$flag) {
                $query = "SELECT users.id FROM users WHERE users.device_token IS NOT NULL 
                            AND users.timezone IN ($timezones)
                            AND
                                users.id NOT IN (select b.user_id
                                    from timetables b
                                    where b.date = '" .
                                    $today .
                                    "');
                        ";
            } else {
                $query ="SELECT users.id  FROM users JOIN timetables ON users.id = timetables.user_id 
                            WHERE timetables.day_status = 2
                                AND users.timezone IN ($timezones)
                                AND timetables.date = '$today'";    
            }
    
            $idsArr = DB::select($query);
            $ids = [];
            foreach ($idsArr as $v) {
                    $ids[] = $v->id;
            }
    
            return $ids;
        }

        return [];
    }

    public function users_with_no_day_Plan($zones = [])
    {
        /**
         * add logic with timezones
         */
        $timezones = GeneralHelper::prepareSqlIn($zones);
        if ($timezones) {
            $today = Carbon::today()->toDateString();
            $query =
                "SELECT users.id FROM users WHERE users.device_token IS NOT NULL 
                    AND users.timezone IN ($timezones)
                    AND
                            users.id NOT IN (select b.user_id
                                from timetables b
                                where b.date = '" .
                    $today .
                    "');
                ";
            $idsArr = DB::select($query);
            $ids = [];
            foreach ($idsArr as $v) {
                $ids[] = $v->id;
            }

            return $ids;
        }

        return [];
    }

    public function users_with_unfinished_day_Plan($zones = [])
    {
        $timezones = GeneralHelper::prepareSqlIn($zones);
        if ($timezones) {
            $today = Carbon::today()->toDateString();
            $query ="SELECT users.id  FROM users JOIN timetables ON users.id = timetables.user_id 
                                         WHERE timetables.day_status = 2
                                         AND users.timezone IN ($timezones)
                                          AND timetables.date = '$today'";
            $idsArr = DB::select($query);
            $ids = [];
            foreach ($idsArr as $v) {
                $ids[] = $v->id;
            }

            return $ids;
        }

        return [];
    }

    private function reminderMessages()
    {
        return [
            RemindTimeHelper::MORNING_TIME => "We hope you wouldn`t forget to create a plan for today :)",
            RemindTimeHelper::EVENING_TIME => "We hope you wouldn`t forget to complete all today`s jobs and tasks :)",
        ];
    }

}
