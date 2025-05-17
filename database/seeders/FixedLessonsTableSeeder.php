<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FixedLesson;

class FixedLessonsTableSeeder extends Seeder
{
    public function run(): void
    {
        FixedLesson::insert([
            [
                'title' => '木曜コース',
                'weekday' => 'Thursday',
                'start_time' => '17:00:00',
                'required_time' => 60,
                'capacity' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => '土曜コース',
                'weekday' => 'Saturday',
                'start_time' => '15:00:00',
                'required_time' => 60,
                'capacity' => 8,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
