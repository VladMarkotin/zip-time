<?php
/**
 * Created by PhpStorm.
 * User: Vlad
 * Date: 24.05.2020
 * Time: 10:55
 */
namespace App\Http\Controllers\Services\PlanServices;

use App\Repositories\TaskRepository as TaskRepository;

class CreateTimeTableService
{
    private $taskRepository;

    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function create(array $data)
    {
        $this->taskRepository->create($data);
    }
} 