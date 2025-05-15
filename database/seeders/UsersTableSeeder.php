<?php

//namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersTableSeeder extends Seeder {
    public function run(): void {
        // スタッフ
        User::create([
            'name' => '教室スタッフ',
            'email' => 'staff@example.com',
            'password' => Hash::make('password'),
            'role' => 'staff',
        ]);

        // 保護者
        User::create([
            'name' => '山田 太郎',
            'email' => 'parent@example.com',
            'password' => Hash::make('password'),
            'role' => 'parent',
        ]);
    }
}
