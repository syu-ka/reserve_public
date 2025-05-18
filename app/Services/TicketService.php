<?php

namespace App\Services;

use App\Models\Ticket;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class TicketService
{
    /**
     * チケットを消費する（予約と紐づけてステータスを更新）
     */
    public function consumeTicket(int $studentSerialNum, int $reservationId): ?Ticket
    {
        // 未使用チケットを1枚取得
        $ticket = Ticket::where('student_serial_num', $studentSerialNum)
            ->where('status', 'available')
            ->first();

        if (!$ticket) {
            return null; // チケットがなければnullを返す
        }

        // チケットを予約に紐づけて消費
        $ticket->reservation_id = $reservationId;
        $ticket->status = 'used';
        $ticket->used_at = Carbon::now();
        $ticket->save();

        return $ticket;
    }

    /**
     * チケットを払い戻す（予約キャンセル時）
     */
    public function refundTicket(int $reservationId): bool
    {
        $ticket = Ticket::where('reservation_id', $reservationId)->first();

        if (!$ticket) {
            return false; // チケットが存在しない場合
        }

        $reservation = Reservation::with('lesson')->find($reservationId);
        if (!$reservation || Carbon::parse($reservation->lesson->date . ' ' . $reservation->lesson->start_time)->isPast()) {
            return false;
        }

        // チケットの状態を払い戻しに戻す
        $ticket->reservation_id = null;
        $ticket->status = 'available';
        $ticket->used_at = null;
        $ticket->save();

        return true;
    }

}
