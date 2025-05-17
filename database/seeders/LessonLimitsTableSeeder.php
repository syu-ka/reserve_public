<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LessonLimit;

class LessonLimitsTableSeeder extends Seeder
{
    public function run(): void
    {
        LessonLimit::truncate(); // 念のためクリア
        LessonLimit::create([
            'max_lessons_per_month' => 3,
        ]);
    }
}
