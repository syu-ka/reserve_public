<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('fixed_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_serial_num')->constrained('students', 'serial_num')->onDelete('cascade'); // 生徒シリアルナンバー
            $table->enum('weekday', ['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun']); // 曜日
            $table->time('start_time'); // 何時に始まるか
            $table->time('end_time');   // 終了時刻
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fixed_schedules');
    }
};
