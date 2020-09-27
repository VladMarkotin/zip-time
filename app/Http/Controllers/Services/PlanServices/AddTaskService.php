<?php
/**
 * Created by PhpStorm.
 * User: Vlad
 * Date: 27.08.2020
 * Time: 14:59
 */

namespace Controllers\Services\PlanServices;


use App\Repositories\TaskRepository;

class AddTaskService
{
    private $taskRepository = null;

    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function create(array $data)
    {
        $data = $this->transformStatusIntoCode($data);
        $this->taskRepository->create($data);
    }

    private function transformStatusIntoCode($data)
    {
        switch($data['status']){
            case 'Обязательное задание': $data['status'] = 2;
                break;
            case 'Необязательное задание': $data['status'] = 1;
                break;
            case 'Задача': $data['status'] = 0;
        }

        return $data;
    }
} 