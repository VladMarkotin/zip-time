<?php
/**
 * Created by PhpStorm.
 * User: Vlad
 * Date: 13.04.2020
 * Time: 8:01
 */

namespace Controllers\Services\AuthServices;


use App\Repositories\DayInfoRepository;
use App\Repositories\FineRepository as FineRep;
use App\Repositories\VacationRepository;
use Illuminate\Support\Carbon as Carbon;

class AuthService {

    private $dInfoRep           = null;
    private $vacationRepository = null;

    public function __construct(DayInfoRepository $dInfoRep,
                                VacationRepository $vacationRepository)
    {
        $this->dInfoRep = $dInfoRep;
        $this->vacationRepository = $vacationRepository;
    }

    public static function isTimetableLegal($id)
    {
        $fineRep = new FineRep();
        $fineRep->model();
        $controlDate = $fineRep->getById($id);
        if($controlDate) {
            if (Carbon::today()->lessThan($controlDate)) {
                dd("У вас не погашен штраф высшего порядка! Доступ закрыт! Вы сможете приступить к планированию
                    $controlDate");
            }
        }
    }

    public static function doTimeTableExist($id)
    {
        $today = Carbon::today();
        $timetableDate = DayInfoRepository::getDateOfLastTimetable($id)->toArray();
        if(is_array($timetableDate) && ($timetableDate)){
            if($today == Carbon::create($timetableDate[0]->date)){
                return true; //На текущий день план уже составлен
            }
        }

        return false;
    }

    public static function isEmergencyOn($id)
    {
        $status = DayInfoRepository::getStatusOfLastTimetable($id);
        if($status == 'Экстренный режим' || ($status == "Экстрен") ){
            return true;
        }

        return false;
    }

    public function isVacationOn($id)
    {
        $today = Carbon::today()->toDateString();
        $data = ["user_id" => $id, "date" => $today];
        $response = $this->vacationRepository->checkVacation($data);

        return $response;
    }
} 