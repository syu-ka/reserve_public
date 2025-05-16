<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_serial_num'); // 生徒の内部連番ID
            $table->foreign('student_serial_num')
                  ->references('serial_num')->on('students')
                  ->onDelete('cascade');

            $table->unsignedBigInteger('reservation_id')->nullable(); // 予約に紐づく場合
            $table->foreign('reservation_id')
                  ->references('id')->on('reservations')
                  ->onDelete('set null');

            $table->string('status')->default('available'); // available, used, refunded
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
