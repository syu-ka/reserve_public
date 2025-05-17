<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ticket;

class TicketsTableSeeder extends Seeder
{
    public function run(): void
    {
        // 既存予約（student_serial_num = 1, lesson_id = 1）に対応するチケットを作成
        Ticket::create([
            'student_serial_num' => 1,     // 対象の生徒
            'reservation_id' => 1,         // 対応する予約ID（Seeder順で1のはず）
            'status' => 'used',            // 使用済みとして登録
            'used_at' => now(),           // 使用日時を現在時刻に設定
        ]);

        // 追加：未使用チケットを事前に持っている状態も作ることができます（必要なら）
        /*
        Ticket::create([
            'student_serial_num' => 1,
            'reservation_id' => null,
            'status' => 'available',
            'used_at' => null,
        ]);
        */
    }
}
