<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fixed_lessons', function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment('授業タイトル例: 木曜コース');
            $table->enum('weekday', ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'])
                  ->comment('実施曜日');
            $table->time('start_time')->comment('開始時間 例: 17:00');
            $table->smallInteger('required_time')->comment('所要時間（分）例: 60');
            $table->smallInteger('capacity')->comment('定員');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fixed_lessons');
    }
};
