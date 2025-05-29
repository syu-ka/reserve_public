<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lesson;
use App\Models\Reservation;
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
        $lessons = Lesson::withCount('reservations')
            ->where('date', '>=', now()->toDateString())->orderBy('date', 'asc')->get();

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
            'date' => 'required|date|after_or_equal:today',
        ]);

        $date = Carbon::parse($request->date);
        $weekday = $date->englishDayOfWeek;
        $warnings = [];

        $fixedLessons = FixedLesson::where('weekday', $weekday)->get();

        if ($fixedLessons->isEmpty()) {
            return back()->withErrors(['date' => '指定された曜日には定期授業パターンが存在しません。']);
        }

        DB::transaction(function () use ($fixedLessons, $date, $weekday, &$warnings) {
            foreach ($fixedLessons as $fixed) {
                // ① 同日・同fixed_lesson_idの授業が既に存在していないか
                $duplicate = Lesson::where('date', $date->toDateString())
                    ->where('fixed_lesson_id', $fixed->id)
                    ->exists();

                if ($duplicate) {
                    $warnings[] = "「{$fixed->title}」はすでに{$date->toDateString()}に登録されているため、新たに登録は行いませんでした。";
                    continue;
                }

                // ② 月ごとのその fixed_lesson_id の登録回数をチェック
                $count = Lesson::whereYear('date', $date->year)
                    ->whereMonth('date', $date->month)
                    ->where('fixed_lesson_id', $fixed->id)
                    ->count();

                $limit = LessonLimit::first()->max_lessons_per_month ?? 3;

                if ($count >= $limit) {
                    $warnings[] = "「{$fixed->title}」は今月の登録上限（{$limit}回）に達しています。";
                    continue;
                }

                $start = Carbon::parse($date->toDateString() . ' ' . $fixed->start_time);

                // 授業登録
                $lesson = Lesson::create([
                    'title' => $fixed->title,
                    'date' => $date->toDateString(),
                    'start_time' => $start->format('H:i:s'),
                    'required_time' => $fixed->required_time,
                    'capacity' => $fixed->capacity,
                    'weekday' => $weekday,
                    'fixed_lesson_id' => $fixed->id,
                ]);

                // 対象生徒に予約とチケット発行
                $students = Student::where('fixed_lesson_id', $fixed->id)->get();

                foreach ($students as $student) {
                    $reservation = \App\Models\Reservation::create([
                        'student_serial_num' => $student->serial_num,
                        'lesson_id' => $lesson->id,
                        'status' => 'reserved',
                    ]);

                    \App\Models\Ticket::create([
                        'student_serial_num' => $student->serial_num,
                        'lesson_id' => $lesson->id,
                        'reservation_id' => $reservation->id,
                        'status' => 'used',
                        'used_at' => now(),
                    ]);
                }
            }
        });

        return redirect()
            ->route('admin.lessons.index')
            ->with('success', "{$weekday} の定期授業を登録しました。")
            ->with('warnings', $warnings);
    }

    public function destroy($id)
    {
        $lesson = Lesson::findOrFail($id);
        $lesson->delete(); // cascadeで予約・チケットも削除される

        return redirect()->route('admin.lessons.index')->with('success', '授業を削除しました。');
    }

}
