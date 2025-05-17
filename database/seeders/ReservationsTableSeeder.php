<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reservation;

class ReservationsTableSeeder extends Seeder
{
    public function run(): void
    {
        Reservation::create([
            'student_serial_num' => 1, // students.serial_num（bigIncrements）を参照
            'lesson_id' => 1, // lessons.id を参照
            'status' => 'reserved', // 予約状態
        ]);

        Reservation::create([
            'student_serial_num' => 2, // students.serial_num（bigIncrements）を参照
            'lesson_id' => 3, // lessons.id を参照
            'status' => 'reserved', // 予約状態
        ]);

        // 必要に応じて追加の予約を登録可能
    }
}
