<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Preplan extends Model
{
    use HasFactory;

    protected $table = 'preplans';
    protected $fillable = ['user_id', 'date', 'jsoned_tasks','created_at', 'updated_at'];
}
