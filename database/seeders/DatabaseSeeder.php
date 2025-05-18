<?php

namespace Database\Seeders;

// use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            // UsersTableSeeder::class,
            FixedLessonsTableSeeder::class,
            StudentsTableSeeder::class,
            LessonsTableSeeder::class,
            ReservationsTableSeeder::class,
            LessonLimitsTableSeeder::class,
            TicketsTableSeeder::class,
            // 追加のSeederがあればここに追加
        ]);
    }
}
