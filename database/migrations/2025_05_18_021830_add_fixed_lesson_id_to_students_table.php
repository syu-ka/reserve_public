<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->unsignedBigInteger('fixed_lesson_id')->nullable()->after('name');

            // 外部キー制約（fixed_lessons.id への参照）
            $table->foreign('fixed_lesson_id')
                ->references('id')
                ->on('fixed_lessons')
                ->onDelete('set null'); // 削除された場合は null にする
        });
    }

    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropForeign(['fixed_lesson_id']);
            $table->dropColumn('fixed_lesson_id');
        });
    }
};
