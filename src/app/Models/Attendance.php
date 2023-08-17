<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\StampController;
use App\Http\Controllers\RestController;

class Attendance extends Model
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

    public function rests()
    {
        return $this->hasMany(Rest::class);
    }
}
