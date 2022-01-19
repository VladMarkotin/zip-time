<?php
namespace App\Repositories\StatRepositories\traits;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

trait GeneralinfoTrait
{
    /*
     * Indicator`s codes:
     * -1 - failed days quantity
     * 0 - emergency mode quantity
     * 1 - weekend quantity
     * 3 - Compl days
     */
    function getStat(array $period, $indicator = -1)
    {
        $userId = Auth::id();
        $query = "SELECT COUNT(id) as 'indicator' FROM timetables WHERE user_id=$userId
                    AND day_status = $indicator
                    AND date BETWEEN '$period[from]' AND '$period[to]' ";
        $response = DB::select($query);

        return $response[0]->indicator;
    }
}
