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
            $table->string('company_name'); // 勤務先名
            $table->string('company_business'); // 勤務先の事業内容
            $table->string('start_enrollment_year');
            $table->string('start_enrollment_month');
            $table->boolean('currently_working')->default(false); // 退職（デフォルトはfalse）
            $table->string('end_enrollment_year')->nullable(); //在籍期間中はnull
            $table->string('end_enrollment_month')->nullable(); //在籍期間中はnull
            $table->string('business_other');
            $table->string('company_post'); // 役職
            $table->string('company_pay_type')->nullable(); // 月給か年俸か
            $table->string('company_pay')->nullable(); // 金額
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
