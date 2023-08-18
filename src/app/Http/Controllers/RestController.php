<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Rest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class RestController extends Controller
{

    public function home()
    {
        $user = Auth::user();
        $attendance = $user->attendance;

        // 休憩開始したかどうかをチェック
        $hasStartedRest = Rest::where('attendance_id', $attendance->id)
            ->where('end_rest', null)
            ->exists();

        // 休憩終了したかどうかをチェック
        $hasEndedRest = Rest::where('attendance_id', $attendance->id)
            ->whereNotNull('end_rest')
            ->exists();

        return view('stamp', compact('hasStartedRest', 'hasEndedRest'));
    }
    public function startRest(Request $request)
    {

        $attendance = Auth::user()->attendance;;
        $rest = new Rest();
        $rest->start_rest = now();
        $rest->attendance_id = $attendance->id;
        $rest->save();

        $this->markUserRestEntryAdded($rest, 'start_rest');

        return redirect()->route('rest.home')->with('success', '休憩を開始しました。');
    }

    private function markUserRestEntryAdded($rest, $action)
    {
        Session::put('user_added_entry_' . Auth::id(), true);
    }

    public function endRest(Request $request)
    {
        $end_rest = Rest::whereNull('end_rest')->get();

        foreach ($end_rest as $end_rest)
            $end_rest->end_rest = now();
        $end_rest->save();

        $this->markUserRestEntryAdded($end_rest, 'end_rest');

        return redirect()->route('rest.home')->with('success', '休憩を終了しました。');
    }
}
