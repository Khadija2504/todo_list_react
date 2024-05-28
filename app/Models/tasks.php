<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tasks extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'content',
        'status',
        'project_id',
        'date_limite',
        'is_archived',
    ];
}
