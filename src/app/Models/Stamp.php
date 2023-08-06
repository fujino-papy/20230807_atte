<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stamp extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'start_work',
        'end_work',
        'user_id',
        'date',
        'created_at',
        'updated_at',
    ];
}
