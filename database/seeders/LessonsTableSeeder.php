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
                'start_time' => $start->copy()->addWeeks($i),
                'end_time' => $start->copy()->addWeeks($i)->addHour(),
                'capacity' => 5,
            ]);
        }
    }
}