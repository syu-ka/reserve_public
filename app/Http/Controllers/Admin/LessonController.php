<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lesson;
use App\Models\FixedLesson;
use App\Models\Student;
use App\Models\Ticket;
use App\Models\LessonLimit;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LessonController extends Controller
{
    public function index()
    {
        $lessons = \App\Models\Lesson::orderBy('date', 'asc')->get();

        return view('admin.lessons.index', compact('lessons'));
    }

    public function create()
    {
        $fixedLessons = FixedLesson::all();
        return view('admin.lessons.create', compact('fixedLessons'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
        ]);

        $date = \Carbon\Carbon::parse($request->date);
        $weekday = $date->englishDayOfWeek;

        // 対象の曜日に該当する定期授業すべて取得
        $fixedLessons = \App\Models\FixedLesson::where('weekday', $weekday)->get();
        $limit = \App\Models\LessonLimit::first()->max_lessons_per_month ?? 3;

        $errors = [];

        DB::transaction(function () use ($fixedLessons, $date, $limit, &$errors) {
            foreach ($fixedLessons as $fixed) {
                // 上限チェック：fixed_lesson_id 単位でチェック
                $count = \App\Models\Lesson::where('fixed_lesson_id', $fixed->id)
                    ->whereYear('date', $date->year)
                    ->whereMonth('date', $date->month)
                    ->count();

                if ($count >= $limit) {
                    $errors[] = "「{$fixed->title}」は今月の上限（{$limit}回）に達しています。";
                    continue;
                }

                $start = \Carbon\Carbon::parse($date->toDateString() . ' ' . $fixed->start_time);

                // 授業登録（fixed_lesson_id を追加）
                $lesson = \App\Models\Lesson::create([
                    'title' => $fixed->title,
                    'date' => $date->toDateString(),
                    'start_time' => $start->format('H:i:s'),
                    'required_time' => $fixed->required_time,
                    'capacity' => $fixed->capacity,
                    'weekday' => $start->englishDayOfWeek,
                    'fixed_lesson_id' => $fixed->id,  // 🔑 新規追加カラム
                ]);

                // チケット配布（全生徒分）
                $students = \App\Models\Student::all();
                foreach ($students as $student) {
                    \App\Models\Ticket::create([
                        'student_serial_num' => $student->serial_num,
                        'lesson_id' => $lesson->id,
                        'status' => 'available',
                    ]);
                }
            }
        });

        if (!empty($errors)) {
            return back()->withErrors($errors);
        }

        return redirect()->route('admin.lessons.index')->with('success', '授業とチケットを登録しました。');
    }


}
