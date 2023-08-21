<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\RestController;
use App\Http\Controllers\StampController;

class Rest extends Model
{
    use HasFactory;

    protected $table = 'rests';

    protected $fillable = [
        'id',
        'start_rest',
        'end_rest',
        'created_at',
        'updated_at',
        'attendance_id'
    ];

    // Attendance モデルとのリレーションを定義
    public function attendance()
    {
        return $this->belongsTo(Attendance::class);
    }
    public function start_rest()
    {
        return $this->hasOne(Rest::class);
    }

    public function end_rest()
    {
        return $this->hasMany(Rest::class);
    }
}
