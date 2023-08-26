<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Rest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class RestController extends Controller
{

    public function home()
    {
        $user = Auth::user();
        $today = Carbon::now()->format('Y-m-d');

        $attendance = $user->attendance()->whereDate('created_at', $today)->first();

        $rest = [
            'startActive' => false,
            'endActive' => false,
        ];
        if ($attendance) {
            if ($attendance->start_rest === null && $attendance->end_rest === null) {
                $rest['startActive'] = true;
            } elseif ($attendance->start_rest !== null && $attendance->end_rest === null)
            {
                $rest['endActive'] = true;
            }
            } else {
        // 勤務情報がない場合、ボタンを非アクティブにする
        $rest['startActive'] = false;
        $rest['endActive'] = false;
        }
        dd($rest);
        return view('stamp', compact("rest"));
    }
    public function startRest(Request $request)
    {
        $user = Auth::user();
        $today = Carbon::now()->format('Y-m-d');

        $attendance = $user->attendance()->whereDate('created_at', $today)->first();
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

        foreach ($end_rest as $rest) { // ここで変数名を $rest に修正
        $rest->end_rest = now();
        $rest->save();
    }


        $this->markUserRestEntryAdded($end_rest, 'end_rest');

        return redirect()->route('rest.home')->with('success', '休憩を終了しました。');
    }
}
