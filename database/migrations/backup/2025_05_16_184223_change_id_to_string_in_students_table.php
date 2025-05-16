<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeIdToStringInStudentsTable extends Migration
{
    public function up(): void
    {
        // 一旦idのprimaryを外す必要があります
        Schema::table('students', function (Blueprint $table) {
            $table->dropPrimary(); // primary keyを一旦削除
            $table->string('id')->change(); // idをstringに変更
            $table->primary('id'); // 再度primary keyを設定
        });
    }

    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropPrimary();
            $table->id()->change(); // 元のauto incrementに戻す（必要に応じて調整）
            $table->primary('id');
        });
    }
}
