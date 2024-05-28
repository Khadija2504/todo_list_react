<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class projects extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'titre',
        'description',
        'type',
        'user_id',
        'is_archived',
    ];
}
