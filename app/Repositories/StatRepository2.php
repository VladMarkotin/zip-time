<?php

namespace App\Repositories;

use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
use Illuminate\Support\Facades\DB;
use MathPHP\Statistics\Average;
use PDO;

//use Your Model

/**
 * Class StatRepository2.
 */
class StatRepository2 extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        //return YourModel::class;
    }

    public function create(array $data)
    {
        // TODO: Implement create() method.
    }

    public function getTotalTime(array $data)
    {
        /*Очень кривое решение! Вынести в отдельный метод!*/
        $start = $end  = "";
        $timeCondition = "";
        if(!is_string($data['date']) ) {
            $start = (isset($data['date']['start'])) ? $data['date']['start'] : "";
            $end = (isset($data['date']['end'])) ? $data['date']['end'] : "";
            $timeCondition = "AND date BETWEEN '". $start ."' AND '".$end."'" ;
        }
        //dd($start);

        $query = "SELECT SUM(time_of_day_plan) total_time FROM `timetables` WHERE user_id = $data[id] AND time_of_day_plan IS NOT NULL $timeCondition";
//        if($timeCondition) dd($query);
        $query = trim($query);
        $response = DB::select($query);
        if($response){
            return $response[0]->total_time;
        }

        return 0;
    }


    public function getAvgMark(array $data)
    {
        /*Очень кривое решение! Вынести в отдельный метод!*/
        $start = $end  = "";
        $timeCondition = "";
        if(!is_string($data['date']) ) {
            $start = (isset($data['date']['start'])) ? $data['date']['start'] : "";
            $end = (isset($data['date']['end'])) ? $data['date']['end'] : "";
            $timeCondition = "AND date BETWEEN '". $start ."' AND '".$end."'" ;
        }
        $query = "SELECT ROUND(AVG(final_estimation),2) avg_mark FROM `timetables` WHERE final_estimation <> -1.00 AND user_id = $data[id] $timeCondition";//AND date <= '".$data['date']."'";
        $query = trim($query);
        $response = DB::select($query);
        if($response){
            return $response[0]->avg_mark;
        }

        return 0;
    }

    public function getAvgOwnMark(array $data)
    {
        /*Очень кривое решение! Вынести в отдельный метод!*/
        $start = $end  = "";
        $timeCondition = "";
        if(!is_string($data['date']) ) {
            $start = (isset($data['date']['start'])) ? $data['date']['start'] : "";
            $end = (isset($data['date']['end'])) ? $data['date']['end'] : "";
            $timeCondition = "AND date BETWEEN '". $start ."' AND '".$end."'" ;
        }
        /*Конец*/
        $query = "SELECT ROUND(AVG(own_estimation),2) avg_own_mark FROM `timetables` WHERE own_estimation <> -1.00 AND user_id = $data[id] $timeCondition";
        $query = trim($query);
        $response = DB::select($query);
        if($response){
            return $response[0]->avg_own_mark;
        }

        return 0;
    }

    public function getMaxMark(array $data)
    {
        /*Очень кривое решение! Вынести в отдельный метод!*/
        $start = $end  = "";
        $timeCondition = "";
        if(!is_string($data['date']) ) {
            $start = (isset($data['date']['start'])) ? $data['date']['start'] : "";
            $end = (isset($data['date']['end'])) ? $data['date']['end'] : "";
            $timeCondition = "AND date BETWEEN '". $start ."' AND '".$end."'" ;
        }
        /*Конец*/
        $query = "SELECT ROUND(Max(final_estimation),2) max_mark FROM `timetables` WHERE final_estimation <> -1.00 AND user_id = $data[id] $timeCondition";
        $query = trim($query);
        $response = DB::select($query);
        if($response){
            return $response[0]->max_mark;
        }

        return 0;
    }

    public function getMinMark(array $data)
    {
        /*Очень кривое решение! Вынести в отдельный метод!*/
        $start = $end  = "";
        $timeCondition = "";
        if(!is_string($data['date']) ) {
            $start = (isset($data['date']['start'])) ? $data['date']['start'] : "";
            $end = (isset($data['date']['end'])) ? $data['date']['end'] : "";
            $timeCondition = "AND date BETWEEN '". $start ."' AND '".$end."'" ;
        }
        /*Конец*/
        $query = "SELECT ROUND(MIN(final_estimation),2) min_mark FROM `timetables` WHERE final_estimation <> -1.00 AND final_estimation <> -2.00 AND user_id = $data[id] $timeCondition";
        $query = trim($query);
        $response = DB::select($query);
        if($response){
            return $response[0]->min_mark;
        }

        return 0;
    }

    /**
     * @param $data
     * @param int $param 0 - для фактической оценки, 1 - для личной оценки
     * @return int
     */
    public function getMedian($data, $param = 0)
    {
        /*Очень кривое решение! Вынести в отдельный метод!*/
        $start = $end  = "";
        $timeCondition = "";
        if(!is_string($data['date']) ) {
            $start = (isset($data['date']['start'])) ? $data['date']['start'] : "";
            $end = (isset($data['date']['end'])) ? $data['date']['end'] : "";
            $timeCondition = "AND date BETWEEN '". $start ."' AND '".$end."'" ;
        }
        /*Конец*/
        if(!$param){
            $query = "SELECT ROUND(final_estimation,2) mediana FROM `timetables` WHERE final_estimation <> -1.00 AND final_estimation <> -2.00 AND user_id = $data[id] $timeCondition";
        }
        else{
            $query = "SELECT ROUND(own_estimation,2) mediana FROM `timetables` WHERE final_estimation <> -1.00 AND final_estimation <> -2.00 AND user_id = $data[id] $timeCondition";
        }

        $query = trim($query);
        $response = DB::select($query);
        if($response) {
            $result[] = array_map(function ($value) {
                return $value->mediana;
            }, $response);
            if ($result[0]) {
                $median = Average::median($result[0]);

                return $median;
            }
        }

        return -1;
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
    }

    public function limit($limit)
    {
        // TODO: Implement limit() method.
    }

    public function orderBy($column, $direction = 'asc')
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

    function __construct()
    {
        // TODO: Implement __construct() method.
    }

    function __destruct()
    {
        // TODO: Implement __destruct() method.
    }

    function __call($name, $arguments)
    {
        // TODO: Implement __call() method.
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
