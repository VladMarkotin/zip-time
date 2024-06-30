<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Log;

class PersonalConfigs extends Model
{
    use HasFactory;

    protected $table = 'personal_configs';
    protected $fillable = [ 'user_id', 'config_block_id', 'config_data','last_updates', 'created_at', 'updated_at'];

    public static function getConfigs()
    {
       return self::where('user_id', Auth::id())->where('config_block_id', 2)->first();
    }

    public static function getOptionViaIndex($index)
    {
        $personalConfigs = json_decode(self::select('config_data')->where([['user_id', Auth::id()],['config_block_id', 2]])->get()->toArray()[0]['config_data']);
        // Log::info(json_encode($personalConfigs));
        // die;
        if ($personalConfigs) {
            return $personalConfigs->rules[0]->$index;
        }

        return null;
    }
}
