<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GPT extends Model
{
    use HasFactory;
    
    protected $table = 'gpt';

    protected $fillable = ['openai_api_secret', 'openai_model', 'oai_temp', 'oai_tokens', ];
}
