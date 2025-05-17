<?php
namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function index()
    {
        $student = Auth::guard('student')->user();
        $reservations = Reservation::with('lesson')
            ->where('student_serial_num', $student->serial_num)
            ->get();

        return view('student.reservations.index', compact('reservations'));
    }

    public function create()
    {
        $lessons = Lesson::all(); // 選択肢用
        return view('student.reservations.create', compact('lessons'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'lesson_id' => 'required|exists:lessons,id',
        ]);

        $student = auth('student')->user();

        $reservation = Reservation::create([
            'student_serial_num' => $student->serial_num,
            'lesson_id' => $request->lesson_id,
            'status' => 'reserved',
        ]);

        // チケット処理が必要であればここで呼び出し

        return redirect()->route('reservations.index')->with('success', '予約が完了しました');
    }

    public function destroy(Reservation $reservation)
    {
        $student = Auth::guard('student')->user();

        if ($reservation->student_serial_num !== $student->serial_num) {
            abort(403, 'この予約を削除する権限がありません');
        }

        $reservation->delete();
        return redirect()->route('student.reservations.index')->with('success', '予約を削除しました');
    }
}
