<?php

namespace App\Services;

use App\Models\Ticket;
use App\Models\Reservation;
use Carbon\Carbon;

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

        $reservation = Reservation::find($reservationId);
        if (!$reservation || $reservation->lesson->start_time < Carbon::now()) {
            return false; // レッスン開始後は払い戻し不可
        }

        // チケットの状態を払い戻しに戻す
        $ticket->reservation_id = null;
        $ticket->status = 'available';
        $ticket->used_at = null;
        $ticket->save();

        return true;
    }
}
