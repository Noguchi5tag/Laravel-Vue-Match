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
        Schema::create('job_bgs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onUpdate('cascade')->unique();
            $table->string('job_title'); // 職種名
            $table->string('company_name'); // 会社名
            $table->date('start_enrollment');
            $table->date('end_enrollment')->nullable(); //在籍期間中はnull
            $table->boolean('currently_working')->default(false); // 退職（デフォルトはfalse）
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_bgs');
    }
};
