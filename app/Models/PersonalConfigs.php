<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PersonalConfigs extends Model
{
    use HasFactory;

    protected $table = 'personal_configs';
    protected $fillable = [ 'user_id', 'config_block_id', 'config_data', 'created_at', 'updated_at'];

    public static function getConfigs()
    {
       return self::where('user_id', Auth::id())->where('config_block_id', 2)->first();
    }
}
