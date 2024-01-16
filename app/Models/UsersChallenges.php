<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersChallenges extends Model
{
    use HasFactory;
    
    protected $table = 'user_challenges';
    
    protected $fillable = [
        
        'user_id',
        'challenge_id',
        'completeness',
        'created_at',
        'updated_at',
    ];
}
