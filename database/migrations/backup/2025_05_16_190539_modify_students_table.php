<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('students', function (Blueprint $table) {
            // 一旦 auto_increment をやめるため unsignedBigInteger に変更
            $table->dropPrimary();
            $table->dropColumn('id'); // idごと削除する場合

            // 既存の id を主キーに
            $table->string('id')->primary()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('students', function (Blueprint $table) {
            // ロールバック時に id カラムを復元
            $table->bigIncrements('id');
            $table->dropPrimary();
            $table->dropColumn('id'); // 必要なら元に戻す
        });
    }
};
