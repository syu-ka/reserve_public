<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Lesson;
use App\Models\Student;
use App\Services\TicketService;

class ReservationController extends Controller
{
    protected $ticketService;

    public function __construct(TicketService $ticketService)
    {
        $this->ticketService = $ticketService;
    }
    
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

    /**
     * 管理者用：予約キャンセル（チケットも払い戻す）
     */
    public function destroy($id)
    {
        $reservation = Reservation::findOrFail($id);

        // チケット払い戻し処理
        $refunded = $this->ticketService->refundTicket($reservation->id);

        if (!$refunded) {
            return back()->withErrors(['error' => 'キャンセル期限を過ぎているため、チケットの払い戻しはできません。']);
        }

        // 予約削除
        $reservation->delete();

        return redirect()->route('admin.reservations.index')->with('success', '予約をキャンセルしました。');
    }
}
