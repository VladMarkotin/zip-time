<?php

namespace Models;

use Illuminate\Database\Eloquent\Model;

class FineModel extends Model
{
    protected $table = "fines2";

    public static function getAll()
    {
        return self::all();
    }
}
