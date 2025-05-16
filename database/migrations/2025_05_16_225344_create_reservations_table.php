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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_serial_num')->constrained('students', 'serial_num')->onDelete('cascade'); // 生徒シリアルナンバー
            $table->foreignId('lesson_id')->constrained()->onDelete('cascade');  // 授業ID
            $table->enum('status', ['reserved', 'cancelled'])->default('reserved'); // 状態
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
