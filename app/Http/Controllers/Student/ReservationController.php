<?php
namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Student;
use App\Models\Lesson;
use App\Models\Ticket;
use App\Services\TicketService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    protected $ticketService;

    public function __construct(TicketService $ticketService)
    {
        $this->ticketService = $ticketService;
    }

    public function index()
    {
        $student = Auth::guard('student')->user();

        // 生徒の available チケット数を取得
        $remainingTickets = Ticket::where('student_serial_num', $student->serial_num)
            ->where('status', 'available')
            ->count();

        // 生徒の予約一覧(過去は弾く)
        $reservations = Reservation::where('student_serial_num', $student->serial_num)
            ->whereHas('lesson', function ($query) {
                $query->where('date', '>=', now()->toDateString());
            })
            ->join('lessons', 'reservations.lesson_id', '=', 'lessons.id')
            ->with('lesson')
            ->orderBy('lessons.date', 'asc')
            ->select('reservations.*')
            ->get();

        return view('student.reservations.index', compact('reservations', 'remainingTickets'));
    }

    public function create()
    {
        $student = Auth::guard('student')->user();

        // 残りチケット数
        $remainingTickets = Ticket::where('student_serial_num', $student->serial_num)
            ->where('status', 'available')
            ->count();

        // 予約済みの授業ID一覧を取得
        $reservedLessonIds = Reservation::where('student_serial_num', $student->serial_num)
            ->pluck('lesson_id')
            ->toArray();

        // 授業一覧を取得（過去の授業は除外）
        $lessons = Lesson::withCount('reservations')
            ->where('date', '>=', now()->toDateString())
            ->get();

        return view('student.reservations.create', compact('lessons', 'remainingTickets', 'reservedLessonIds'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'lesson_id' => 'required|exists:lessons,id',
        ]);

        $student = auth('student')->user();

        // ① 予約を作成
        $reservation = Reservation::create([
            'student_serial_num' => $student->serial_num,
            'lesson_id' => $request->lesson_id,
            'status' => 'reserved',
        ]);

        // ② チケットを消費
        $ticket = app(\App\Services\TicketService::class)->consumeTicket(
            $student->serial_num,
            $reservation->id
        );

        // ③ チケットが無ければ予約を削除してエラー
        if (!$ticket) {
            $reservation->delete();
            return redirect()->route('student.reservations.create')
                ->with('error', 'チケットが不足しています。');
        }

        return redirect()->route('student.reservations.index')->with('success', '予約が完了しました');
    }

    public function destroy(Reservation $reservation)
    {
        $student = Auth::guard('student')->user();

        if ($reservation->student_serial_num !== $student->serial_num) {
            abort(403, 'この予約を削除する権限がありません');
        }

        // チケット払い戻し
        $refunded = $this->ticketService->refundTicket($reservation->id);

        if (!$refunded) {
            return back()->withErrors(['キャンセル期限を過ぎているか、チケットが見つかりません。']);
        }

        $reservation->delete();

        return redirect()->route('student.reservations.index')->with('success', '予約をキャンセルしました');
    }
}
