<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\User;

class StudentsTableSeeder extends Seeder {
    public function run(): void {
        $parent = User::where('email', 'parent@example.com')->first();

        Student::create([
            'name' => '山田 花子',
            'birth_date' => '2013-04-10',
            'parent_id' => $parent->id,
        ]);
    }
}
