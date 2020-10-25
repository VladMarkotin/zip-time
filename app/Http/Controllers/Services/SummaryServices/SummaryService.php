<?php
/**
 * Created by PhpStorm.
 * User: Vlad
 * Date: 12.10.2020
 * Time: 15:24
 */
namespace App\Http\Controllers\Services\SummaryServices;


use App\Repositories\DayInfoRepository;
use App\Repositories\TaskRepository;

class SummaryService
{
    private $dayInfoRepository = null;
    private $taskRepository    = null;

    public function __construct(DayInfoRepository $dayInfoRepository,
                                TaskRepository $taskRepository)
    {
        $this->dayInfoRepository = $dayInfoRepository;
        $this->taskRepository    = $taskRepository;
    }

    public function estimateDay(array $data)
    {
        $answers = [];
        $answers[] = $this->checkComment($data["comment"]);//надо отправить только комметарий
        $answers[] = $this->checkOwnMark($data["own_mark"]);
        $answers[] = $this->checkNecessary($data["necessary"]);
        //die(print_r($answers));
        return $answers;
    }

    private function checkComment($comment)
    {
        $comment = trim($comment);
        $comment = htmlspecialchars($comment);
        if(strlen($comment > 65535))
            return 0;

        return 1;
    }

    private function checkOwnMark($ownMark)
    {
        if($ownMark > 200)
            return 0;

        return 1;
    }

    private function checkNecessary($necessary)
    {
        $necessary = trim($necessary);
        $necessary = htmlspecialchars($necessary);
        if(strlen($necessary > 65535))
            return 0;

        return 1;
    }
} 