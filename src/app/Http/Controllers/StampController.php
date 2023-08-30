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

            $attendance = $user->attendance()->whereDate('date', $today)->first();

            $rest = [
                'startActive' => false,
                'endActive' => false,
            ];

            if ($attendance) {
                if ($attendance->rests->isEmpty()) {
                    $rest['startActive'] = true;
                } else {
                    $lastRest = $attendance->rests->last();
                    if ($lastRest->start_rest !== null && $lastRest->end_rest === null) {
                        $rest['endActive'] = true;
                    } elseif ($lastRest->start_rest !== null && $lastRest->end_rest !== null) {
                        $rest['startActive'] = true;
                    }
                }
            } else {
                $rest['startActive'] = false;
                $rest['endActive'] = false;
            }

                $hasEndWork = Attendance::where('user_id', $user->id)
                    ->where('date', now()->toDateString())
                    ->whereNotNull('end_work')
                    ->exists();
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
        $attendance=Attendance::Paginate(5);
        $attendanceWithWorktime = [];

    foreach ($attendance as $entry) {
        if ($entry->start_work && $entry->end_work) {
            $startWorkTimestamp = strtotime($entry->start_work);
            $endWorkTimestamp = strtotime($entry->end_work);
            $workDurationInSeconds = $endWorkTimestamp - $startWorkTimestamp;
            $hours = floor($workDurationInSeconds / 3600);
            $minutes = floor(($workDurationInSeconds % 3600) / 60);
            $worktime = $hours . '時間' . $minutes . '分';
        } else {
            $worktime = 'Work duration not available';
        }

        $entry->worktime = $worktime;
        $attendanceWithWorktime[] = $entry;

      // 休憩時間を計算して追加
        $totalRestTime = Rest::where('attendance_id', $entry->id)
            ->whereNotNull('end_rest')
            ->sum(function ($restRecord) {
                return strtotime($restRecord->end_rest) - strtotime($restRecord->start_rest);
            });

        $restTimeInMinutes = round($totalRestTime / 60);
        $restTime = $restTimeInMinutes . '分';

        $entry->worktime = $worktime;
        $entry->resttime = $restTime;
        $attendanceWithWorktime[] = $entry;
    }

        return view('list' , compact('attendance','attendanceWithWorktime'));
    }
}

