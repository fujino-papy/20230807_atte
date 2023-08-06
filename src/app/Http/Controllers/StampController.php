<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stamp;

class StampController extends Controller
{
    public function home()
    {
        return view('stamp');
    }

    public function startWork(Request $request)
    {
        $attendances = $request->only(['id', 'start_work', 'end_work', 'user_id', 'date', 'created_at', 'updated_at',]);
        Stamp::create($attendances);
    }
}

