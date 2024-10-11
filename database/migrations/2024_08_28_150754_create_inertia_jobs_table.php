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
        Schema::create('inertia_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('companyName')->nullable(); // 会社名
            $table->string('WantedTitles')->nullable(); // 募集タイトル
            $table->string('Occupation')->nullable(); // 職種
            $table->text('companyAddress')->nullable(); // 会社の住所
            $table->integer('companyPay')->nullable(); // 給料
            $table->text('dutyStation')->nullable(); // 勤務地
            $table->text('workDescription')->nullable(); // 仕事内容
            $table->text('payDescription')->nullable(); // 給与詳細
            $table->integer('travelExpenses')->nullable(); // 交通費
            $table->text('Welfare')->nullable(); // 福利厚生
            $table->time('startWork')->nullable(); // 勤務開始時間
            $table->time('endWork')->nullable(); // 勤務終了時間
            $table->string('workDays')->nullable(); // 出勤日
            $table->string('freeDays')->nullable(); // 休日
            $table->string('NearestStation')->nullable(); // 最寄り駅
            $table->text('workOther')->nullable(); // その他
            $table->integer('status')->default(0);
            $table->string('registrant')->nullable();
            $table->boolean('is_checked')->default(0);
            $table->string('search_keywords')->nullable();
            $table->string('image1')->nullable();
            $table->string('image2')->nullable();
            $table->string('image3')->nullable();
            $table->string('image4')->nullable();
            $table->string('image5')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inertia_jobs');
    }
};
