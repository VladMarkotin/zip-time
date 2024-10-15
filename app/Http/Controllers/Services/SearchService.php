<?php

namespace App\Http\Controllers\Services;
use App\Models\SavedTask;
use App\Models\DefaultSavedTasks;

class SearchService
{
    private $savedTaskModel         = null;
    private $defaultSavedTasksModel = null;

    public function __construct(SavedTask         $savedTaskModel,
                                DefaultSavedTasks $defaultSavedTasks,
                                )
    {
        $this->savedTaskModel         = $savedTaskModel;
        $this->defaultSavedTasksModel = $defaultSavedTasks;
    }

    public function searchHashCodes($searchValue)
    {
            $queryOne = $this->savedTaskModel::select('hash_code', 'task_name')
                ->where('hash_code', 'like', "%$searchValue%")
                ->orWhere('task_name', 'like', "%$searchValue%");

            $queryTwo = $this->defaultSavedTasksModel::select('hash_code', 'task_name')
                ->where('hash_code', 'like', "%$searchValue%")
                ->orWhere('task_name', 'like', "%$searchValue%");

            return $queryOne->union($queryTwo)->pluck('hash_code')->toArray();
    }
} 