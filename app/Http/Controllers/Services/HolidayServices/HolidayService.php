<?php
/**
 * Created by PhpStorm.
 * User: Vlad
 * Date: 25.11.2020
 * Time: 14:36
 */
namespace Controllers\Services\HolidayServices;


use Carbon\CarbonImmutable;
use Illuminate\Support\Carbon as Carbon;

/**
 * Class HolidayService
 * @package Controllers\Services\HolidayServices
 * На самом деле сервис работает с отпусками, а не с праздниками!
 */
class HolidayService
{
    private $carbon;
    private $carbonImmutable;

    public function __construct(Carbon $carbon,
                                CarbonImmutable $carbonImmutable
                               )
    {
        $this->carbon          = $carbon;
        $this->carbonImmutable = $carbonImmutable;
    }

    public function IsVacationOn($id)
    {
        return false;
    }

    public function setVacation($id)
    {}

    public function isVacationAble($id)
    {
        return false;
    }
} 