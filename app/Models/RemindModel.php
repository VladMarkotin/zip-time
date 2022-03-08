<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class RemindModel extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'reminders';
    protected $fillable = ['user_id', 'is_active', 'date', 'time', 'text', 'created_at', 'updated_at'];


}
