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
            $table->string('companyName'); // 会社名
            $table->string('WantedTitles'); // 募集タイトル
            $table->string('Occupation'); // 職種
            $table->text('companyAddress'); // 会社の住所
            $table->integer('companyPay'); // 給料
            $table->text('dutyStation'); // 勤務地
            $table->text('workDescription'); // 仕事内容
            $table->text('payDescription'); // 給与詳細
            $table->integer('travelExpenses'); // 交通費
            $table->text('Welfare'); // 福利厚生
            $table->integer('startWork'); // 勤務開始時間
            $table->integer('endWork'); // 勤務終了時間
            $table->string('workDays'); // 出勤日
            $table->string('freeDays'); // 休日
            $table->string('NearestStation'); // 最寄り駅
            $table->text('workOther'); // その他
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
