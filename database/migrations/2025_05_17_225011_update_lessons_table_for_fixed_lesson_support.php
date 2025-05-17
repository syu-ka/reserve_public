<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('lessons', function (Blueprint $table) {
            // 授業日の追加
            $table->date('date')->after('title')->comment('授業日');

            // 授業開始時刻の変更
            $table->time('start_time')->change()->comment('授業開始時刻');

            // 所要時間の追加（例：60分）
            $table->smallInteger('required_time')->after('start_time')->comment('所要時間（分）');

            // 不要になったカラムの削除
            $table->dropColumn('end_time');
        });
    }

    public function down(): void
    {
        Schema::table('lessons', function (Blueprint $table) {
            // 逆操作：カラム削除と復元
            $table->dropColumn('date');
            $table->dropColumn('required_time');

            // 授業開始時刻を復元
            $table->dateTime('start_time')->change()->comment('授業開始日と時刻（復元）');
            $table->dateTime('end_time')->after('start_time')->nullable()->comment('授業終了時刻（復元）');
        });
    }
};
