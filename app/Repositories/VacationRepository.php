<?php

namespace App\Repositories;

use Controllers\Services\PlanServices\DayInfoService;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
use Illuminate\Support\Facades\DB;
//use Your Model

/**
 * Class VacationRepository.
 */
class VacationRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    private $dayInfoService = null;


    public function model()
    {
        //return YourModel::class;
    }

    public function setVacation($data)
    {
        if($data) {
            array_walk($data, function(&$x) {$x = "'$x'";});
            $query = "INSERT INTO holidays (user_id,start,end) VALUES($data[id],$data[start], $data[end] )";
            $query = trim($query);
            DB::insert($query);
            $this->dayInfoService->createDay("Отпуск");

            return 1;
        }

        return 0;
    }

    public function checkVacation($data)
    {
        if($data) {
            $query = "SELECT holiday_id FROM `holidays` WHERE user_id = $data[user_id] AND '$data[date]' BETWEEN start AND end";
            $query = trim($query);
            //die($query);
            $response = DB::select($query);
            if($response){
                return 1;
            }
        }

        return 0;
    }

    function __call($name, $arguments)
    {
        // TODO: Implement __call() method.
    }

    public function create(array $data)
    {
        // TODO: Implement create() method.
    }

    public function createMultiple(array $data)
    {
        // TODO: Implement createMultiple() method.
    }

    public function delete()
    {
        // TODO: Implement delete() method.
    }

    public function deleteById($id)
    {
        // TODO: Implement deleteById() method.
    }

    public function deleteMultipleById(array $ids)
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
    }

    public function limit($limit)
    {
        // TODO: Implement limit() method.
    }

    public function orderBy($column, $value)
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

    function __construct(DayInfoService $dayInfoService)
    {
        // TODO: Implement __construct() method.
        $this->dayInfoService = $dayInfoService;
    }

    function __destruct()
    {
        // TODO: Implement __destruct() method.
    }

    public static function __callStatic($name, $arguments)
    {
        // TODO: Implement __callStatic() method.
    }

    function __get($name)
    {
        // TODO: Implement __get() method.
    }

    function __set($name, $value)
    {
        // TODO: Implement __set() method.
    }

    function __isset($name)
    {
        // TODO: Implement __isset() method.
    }

    function __unset($name)
    {
        // TODO: Implement __unset() method.
    }

    function __sleep()
    {
        // TODO: Implement __sleep() method.
    }

    function __wakeup()
    {
        // TODO: Implement __wakeup() method.
    }

    function __toString()
    {
        // TODO: Implement __toString() method.
    }

    function __invoke()
    {
        // TODO: Implement __invoke() method.
    }

    static function __set_state($an_array)
    {
        // TODO: Implement __set_state() method.
    }

    function __clone()
    {
        // TODO: Implement __clone() method.
    }
}
