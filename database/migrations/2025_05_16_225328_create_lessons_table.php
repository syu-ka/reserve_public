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
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // 授業名（例: プログラミング初級）
            $table->dateTime('start_time'); // 開始日時
            $table->dateTime('end_time');   // 終了日時
            $table->unsignedSmallInteger('capacity')->nullable(); // 最大人数（任意）(非負の整数)
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lessons');
    }
};
