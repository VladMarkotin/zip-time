<?php
/**
 * Created by PhpStorm.
 * User: Vlad
 * Date: 01.12.2020
 * Time: 12:01
 */

namespace App\Http\Controllers\Services\VacationServices;


use App\Repositories\VacationRepository;

class VacationService
{
    private $vacationRepository = null;

    public function __construct(VacationRepository $vacationRepository)
    {
        $this->vacationRepository = $vacationRepository;
    }

    public function setVacation($data)
    {
        $response = $this->vacationRepository->setVacation($data);

        return $response;
    }

    public function checkVacation(array $data)
    {
        $this->checkVacation($data);
    }
} 