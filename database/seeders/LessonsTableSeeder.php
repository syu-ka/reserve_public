<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LessonsTableSeeder extends Seeder
{
    public function run(): void
    {
        $lessons = [
            // 定期授業（土曜Aコース）
            [
                'title' => '土曜Aコース',
                'date' => '2025-06-01',
                'start_time' => '14:00:00',
                'required_time' => 60,
                'capacity' => 8,
                'weekday' => 'Saturday',
                'fixed_lesson_id' => 1, // fixed_lessonsテーブルに該当IDが存在している必要あり
            ],
            [
                'title' => '土曜Aコース',
                'date' => '2025-06-08',
                'start_time' => '14:00:00',
                'required_time' => 60,
                'capacity' => 8,
                'weekday' => 'Saturday',
                'fixed_lesson_id' => 1,
            ],

            // 臨時（カスタマイズ）授業（fixed_lesson_idなし）
            [
                'title' => '臨時JavaScript特訓',
                'date' => '2025-06-05',
                'start_time' => '17:00:00',
                'required_time' => 90,
                'capacity' => 6,
                'weekday' => 'Thursday',
                'fixed_lesson_id' => null,
            ],
        ];

        foreach ($lessons as $lesson) {
            DB::table('lessons')->insert([
                ...$lesson,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
