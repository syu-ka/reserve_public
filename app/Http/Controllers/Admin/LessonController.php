<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lesson;
use App\Models\Student;
use App\Models\Ticket;
use App\Models\LessonLimit;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LessonController extends Controller
{
    public function create()
    {
        return view('admin.lessons.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'time_slot' => 'required',
            'capacity' => 'required|integer|min:1',
        ]);

        $date = new Carbon($request->date);

        // 今月の該当曜日の授業数を確認
        $currentMonthCount = Lesson::whereYear('date', $date->year)
            ->whereMonth('date', $date->month)
            ->where('weekday', $date->englishDayOfWeek)
            ->count();

        $limit = LessonLimit::first()->max_lessons_per_month;

        if ($currentMonthCount >= $limit) {
            return back()->withErrors(['date' => 'この曜日の今月の授業はすでに上限に達しています。']);
        }

        // 授業登録とチケット配布をトランザクションでまとめる
        DB::transaction(function () use ($request, $date) {
            $lesson = Lesson::create([
                'date' => $date->toDateString(),
                'weekday' => $date->englishDayOfWeek,
                'time_slot' => $request->time_slot,
                'capacity' => $request->capacity,
                'created_by' => auth('admin')->id(),
            ]);

            // 全生徒にチケット配布
            $students = Student::all();
            foreach ($students as $student) {
                Ticket::create([
                    'student_serial_num' => $student->serial_num,
                    'lesson_id' => $lesson->id,
                    'status' => 'available',
                ]);
            }
        });

        return redirect()->route('admin.reservations.index')->with('success', '授業を登録し、チケットを配布しました。');
    }
}
