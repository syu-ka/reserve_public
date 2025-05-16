<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {
            // 既存の主キーを削除
            $table->dropPrimary();

            // AUTO_INCREMENT な id を削除
            $table->dropColumn('id');
        });

        Schema::table('students', function (Blueprint $table) {
            // 新たに string 型の id を追加し、主キーに設定
            $table->string('id')->primary();
        });
    }

    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            // string 型の id を削除
            $table->dropPrimary();
            $table->dropColumn('id');
        });

        Schema::table('students', function (Blueprint $table) {
            // 元の id を復元（auto increment）
            $table->id();
        });
    }
};
