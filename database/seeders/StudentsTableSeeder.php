<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Student;
// use App\Models\User;

class StudentsTableSeeder extends Seeder {
    public function run(): void {
        // $parent = User::where('email', 'parent@example.com')->first();

        Student::create([
            'id' => "aabb0001",
            'name' => '山田 花子',
            'password' => Hash::make('password123'), // 平文のパスワードをハッシュ化
            'fixed_lesson_id' => 1,
        ]);

        Student::create([
            'id' => "abcd0002",
            'name' => '山田 太郎',
            'password' => Hash::make('password456'), // 平文のパスワードをハッシュ化
            'fixed_lesson_id' => 2,
        ]);
    }
}
