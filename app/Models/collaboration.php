<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class collaboration extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'project_id',
        'user_id',
        'is_active',
    ];

}
