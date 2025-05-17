<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('lessons', function (Blueprint $table) {
            $table->unsignedBigInteger('fixed_lesson_id')->nullable();

            // 外部キー制約（必要に応じてonDelete設定を）
            $table->foreign('fixed_lesson_id')
                  ->references('id')
                  ->on('fixed_lessons')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('lessons', function (Blueprint $table) {
            $table->dropForeign(['fixed_lesson_id']);
            $table->dropColumn('fixed_lesson_id');
        });
    }
};
