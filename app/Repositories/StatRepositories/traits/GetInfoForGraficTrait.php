<?php
namespace App\Repositories\StatRepositories\traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

trait GetInfoForGraficTrait
{
    public static function getInfoForGraphics(array $data, $opt = 1)//$opt = 1 - final_estimation, other - own_estimation
    {
        $data['id'] = Auth::id();
        $requestedMark = ($opt == 1) ? 'final_estimation': 'own_estimation';
        $query = "SELECT date, $requestedMark FROM timetables WHERE day_status IN (3, -1) AND user_id = $data[id]
                   AND date BETWEEN '$data[from]' AND '$data[to]'";

        return DB::select($query);
    }
}
