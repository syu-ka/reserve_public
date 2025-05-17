<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Lesson;
use App\Models\Student;

class ReservationController extends Controller
{
    public function index()
    {
        $reservations = Reservation::with('student', 'lesson')->get();

        return view('admin.reservations.index', compact('reservations'));
    }

    public function create()
    {
        $students = Student::all();
        $lessons = Lesson::all();

        return view('admin.reservations.create', compact('students', 'lessons'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_serial_num' => 'required|exists:students,serial_num',
            'lesson_id' => 'required|exists:lessons,id',
        ]);

        Reservation::create([
            'student_serial_num' => $request->student_serial_num,
            'lesson_id' => $request->lesson_id,
        ]);

        return redirect()->route('admin.reservations.index')->with('success', '予約を作成しました');
    }

    public function destroy(Reservation $reservation)
    {
        $reservation->delete();

        return redirect()->route('admin.reservations.index')->with('success', '予約を削除しました');
    }
}
