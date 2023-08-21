<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Rest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class StampController extends Controller
{
    public function home()
    {
        $user = Auth::user();

        // 今日のエントリーを追加したかどうかをチェック
        $hasAddedEntry = $this->hasUserAddedEntryToday($user);

        // 勤務終了したかどうかをチェック
        $hasEndWork = Attendance::where('user_id', $user->id)
            ->where('date', now()->toDateString())
            ->whereNotNull('end_work')
            ->exists();

        // 勤務終了したら休憩ボタンを無効にする
        $disableRestButtons = $hasEndWork;

        return view('stamp', compact('hasAddedEntry', 'hasEndWork', ));
    }


    public function startWork(Request $request)
    {

        $user = Auth::user();

        if ($this->hasUserAddedEntryToday($user)) {
            return redirect('/stamp/home')->with('error', 'You can only add one entry per day.');
        }
        $user = Auth::user();
        $attendances = new Attendance();
        $attendances->start_work = now();
        $attendances->user_id = $user->id;
        $attendances->date = now()->toDateString();
        $attendances->save();

        $this->markUserEntryAdded($user);

        return redirect()->route('stamp.home');
    }

    private function hasUserAddedEntryToday($user)
    {
        return Session::has('user_added_entry_' . $user->id);
    }

    private function markUserEntryAdded($user)
    {
        Session::put('user_added_entry_' . $user->id, true);
    }

    public function endWork()
    {
        $user = Auth::user();
        $endwork = Attendance::whereNull('end_work')->get();

        foreach ($endwork as $end_work)
            $end_work->end_work = now();
        $end_work->save();

        return redirect()->route('stamp.home');
    }
}

