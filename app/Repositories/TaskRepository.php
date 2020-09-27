<?php
namespace App\Repositories;


use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
use Models\TaskModel;
use Illuminate\Support\Facades\DB;

/**
 * Class TaskRepository.
 */
class TaskRepository extends BaseRepository
{
    private $taskModel         = null;
    private $dayInfoRepository = null;

    public function __construct(TaskModel $taskModel,
                                DayInfoRepository $dayInfoRepository)
    {
        $this->taskModel         = $taskModel;
        $this->dayInfoRepository = $dayInfoRepository;
    }

    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return TaskModel::class;
    }

    public function create(array $data)
    {
        // TODO: Implement create() method.
        $dataForInsert = [];
        if(!isset($data["added"])) {
            foreach ($data as $k => $v) {
                if ($k != 2) { //убираем лишний массив со статусом
                    foreach ($v as $val) {
                        $dataForInsert[] = [
                            "timetable_id" => $this->dayInfoRepository->lastTimetable(),
                            "task_name" => $val[0],
                            "details" => $val[2],
                            "time" => $val[1],
                            "status" => $val[3], //временное решение.Нужно
                        ];
                    }
                }
            }
        } else{
                $dataForInsert[] = [
                    "timetable_id" => $this->dayInfoRepository->lastTimetable(),
                    "task_name" => $data["shortName"],
                    "details" => $data["note"],
                    "time" => $data["time"],
                    "status" => $data["status"],
                ];
        }
        TaskModel::insert($dataForInsert);
        //die("yea!");
    }

    public function createMultiple(array $data)
    {
        // TODO: Implement createMultiple() method.
    }

    public function delete()
    {
        // TODO: Implement delete() method.
    }

    public function deleteById($id) : bool
    {
        // TODO: Implement deleteById() method.
    }

    public function deleteMultipleById(array $ids) : int
    {
        // TODO: Implement deleteMultipleById() method.
    }

    public function first(array $columns = ['*'])
    {
        // TODO: Implement first() method.
    }

    public function get(array $columns = ['*'])
    {
        // TODO: Implement get() method.
    }

    public function getById($id, array $columns = ['*'])
    {
        // TODO: Implement getById() method.
    }

    public function getByColumn($item, $column, array $columns = ['*'])
    {
        // TODO: Implement getByColumn() method.
    }

    public function paginate($limit = 25, array $columns = ['*'], $pageName = 'page', $page = null)
    {
        // TODO: Implement paginate() method.
    }

    public function updateById($id, array $data, array $options = [])
    {
        // TODO: Implement updateById() method.
        //die(print_r($data));
        $taskNames = $this->getTaskNamesWithTimetableId($id);
        array_shift($data);//избавляемся от пустых инпутов,которые связаны с формой на + нового задания после создания плана
        foreach($data as $i => $v){
            $taskId = $data[$i][2];
            $mark = (is_numeric($data[$i][0])) ? $data[$i][0]: 'NULL';
            $note = ($data[$i][1]) ? $data[$i][1]: "NULL" ;
            $query = "UPDATE tasks SET `mark`=$mark, `note`= '".$note."' WHERE  `task_id` = "."$taskId";
            DB::update($query);
        }

        return true;

    }

    public function limit($limit)
    {
        // TODO: Implement limit() method.
    }

    public function orderBy($column,  $direction = 'asc')
    {
        // TODO: Implement orderBy() method.
    }

    public function where($column, $value, $operator = '=')
    {
        // TODO: Implement where() method.
    }

    public function whereIn($column, $value)
    {
        // TODO: Implement whereIn() method.
    }

    public function with($relations)
    {
        // TODO: Implement with() method.
    }

    private function getTaskNamesWithTimetableId($timetableId)
    {
        $tasks = DB::table('tasks')
            ->select(DB::raw('task_id'),DB::raw('task_name'), DB::raw('mark'), DB::raw('note'))
            ->where('timetable_id','=', $timetableId);

        return $tasks->get()->toArray();
    }
}
