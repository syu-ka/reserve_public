<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('birth_date'); // 生年月日
            $table->unsignedBigInteger('parent_id');
            $table->timestamps();

            $table->foreign('parent_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('students');
    }
};
