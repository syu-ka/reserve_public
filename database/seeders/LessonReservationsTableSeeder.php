<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LessonReservation;
use App\Models\Student;
use App\Models\Lesson;

class LessonReservationsTableSeeder extends Seeder {
    public function run(): void {
        $student = Student::first();
        $lessons = Lesson::take(2)->get();

        foreach ($lessons as $lesson) {
            LessonReservation::create([
                'student_id' => $student->id,
                'lesson_id' => $lesson->id,
            ]);
        }
    }
}