<?php

namespace App\Repositories;

use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
use Models\FineModel;
use Illuminate\Support\Carbon as Carbon;
//use Your Model

/**
 * Class FineRepository.
 */
class FineRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return FineModel::class;
    }

    public function get(array $columns = ['*'])
    {
        return FineModel::getAll();
    }

    public function getById($id, array $columns = ['*'])
    {
        $infoFromDB = (FineModel::getAll()->where("user_id", "=", $id)->toArray());
        if ($infoFromDB) {
            $dateOfStart = $infoFromDB[0]["day_of_start"];
            $controlDate = Carbon::createFromDate($dateOfStart)->addDays(3);

            return $controlDate;
        }

        return false;
    }

    public function limit($limit)
    {
        // TODO: Implement limit() method.
    }

    public function deleteById($id) : bool
    {
        // TODO: Implement deleteById() method.
        return false;
    }

    public function first(array $columns = ['*'])
    {
        // TODO: Implement first() method.
    }

    public function where($column, $value, $operator = '=')
    {
        // TODO: Implement where() method.
    }

    public function with($relations)
    {
        // TODO: Implement with() method.
    }

    public function create(array $data)
    {
        // TODO: Implement create() method.
    }

    public function paginate($limit = 25, array $columns = ['*'], $pageName = 'page', $page = null)
    {
        // TODO: Implement paginate() method.
    }

    public function whereIn($column, $value)
    {
        // TODO: Implement whereIn() method.
    }

    public function createMultiple(array $data)
    {
        // TODO: Implement createMultiple() method.
    }

    public function delete()
    {
        // TODO: Implement delete() method.
    }

    public function deleteMultipleById(array $ids) : int
    {
        // TODO: Implement deleteMultipleById() method.
    }

    public function getByColumn($item, $column, array $columns = ['*'])
    {
        // TODO: Implement getByColumn() method.
    }

    public function updateById($id, array $data, array $options = [])
    {
        // TODO: Implement updateById() method.
    }

    public function orderBy($column,  $direction = 'asc')
    {
        // TODO: Implement orderBy() method.

    }
}
