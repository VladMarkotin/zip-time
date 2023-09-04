<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DefaultConfigs extends Model
{
    use HasFactory;

    protected $table = 'default_configs';
    protected $fillable = [ 'config_data', 'config_block_id', 'created_at', 'updated_at'];

    public function getConfigs()
    {

    }
}
