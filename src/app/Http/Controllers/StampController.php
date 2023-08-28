<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Rest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class StampController extends Controller
{
        public function home()
        {
            $user = Auth::user();

            // 今日のエントリーを追加したかどうかをチェック
            $attendance = Attendance::where('user_id', $user->id)
                ->where('date', now()->toDateString())
                ->whereNotNull('start_work')
                ->first();

            if ($attendance && is_null($attendance->end_work)) {
                $startWorkData = $attendance->start_work;
                $endWorkData = null; // 'end_work' カラムにデータがない場合は明示的に null を設定
            } else {
                $startWorkData = null;
                $endWorkData = null;
            }
            // 勤務終了したかどうかをチェック
            $hasEndWork = Attendance::where('user_id', $user->id)
                ->where('date', now()->toDateString())
                ->whereNotNull('end_work')
                ->exists();

            // 勤務終了したら休憩ボタンを無効にする
            $disableRestButtons = $hasEndWork;
            //休憩管理部分
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
            } elseif ($attendance->start_rest !== null && $attendance->end_rest === null) {
                $rest['endActive'] = true;
            }
            } else {
            // 勤務情報がない場合、ボタンを非アクティブにする
            $rest['startActive'] = false;
            $rest['endActive'] = false;
            }

            $hasEndWork = Attendance::where('user_id', $user->id)
            ->where('date', now()->toDateString())
            ->whereNotNull('end_work')
            ->exists();

        // 勤務終了したら休憩ボタンを無効にする
        $disableRestButtons = $hasEndWork;

        return view('stamp',compact('attendance' , 'rest','hasEndWork'));
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

    public function list()
    {
        return view('list');
    }
}

