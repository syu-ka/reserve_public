<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Lesson;
use Carbon\Carbon;

class LessonsTableSeeder extends Seeder {
    public function run(): void {
        $start = Carbon::parse('next Thursday')->setTime(16, 0);
        for ($i = 0; $i < 3; $i++) {
            Lesson::create([
                'title' => '英会話レッスン',
                'start_time' => $start->copy()->addWeeks($i),
                'end_time' => $start->copy()->addWeeks($i)->addHour(),
                'capacity' => $i+1, // 最大人数を1, 2, 3とする
                // 'capacity' => null, // 最大人数を指定しない場合はコメントアウト
            ]);
        }
    }
}