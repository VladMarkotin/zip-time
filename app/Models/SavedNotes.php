<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavedNotes extends Model
{
    use HasFactory;

    protected $table = 'notes';
    protected $fillable = ['task_id', 'saved_task_id', 'note', 'created_at', 'updated_at'];

    public function getCreatedAtAttribute($date)
    {
        //die(var_dump($date));
        $dateObj = new \DateTimeImmutable($date);

        return $dateObj->format('d.m.Y');
    }


}
