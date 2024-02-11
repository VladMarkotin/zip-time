<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DefaultConfigs extends Model
{
    use HasFactory;

    protected $table = 'default_configs';
    protected $fillable = [ 'config_data', 'config_block_id', 'created_at', 'updated_at'];

    // public static function getConfigs()
    // {
    //    return self::select('*')->where('config_block_id', 2)->get()->toJson(JSON_UNESCAPED_UNICODE);
    // }

    public static function getConfigs()
    {
       return self::select('*')->where('config_block_id', 2)->get();
    }
 }
