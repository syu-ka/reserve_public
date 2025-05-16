<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('lesson_reservations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id');
            $table->unsignedBigInteger('lesson_id');
            $table->timestamps();

            $table->unique(['id', 'lesson_id']); // 同じ授業に重複予約を防ぐ
            $table->foreign('id')->references('id')->on('students')->onDelete('cascade');
            $table->foreign('lesson_id')->references('id')->on('lessons')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('lesson_reservations');
    }
};