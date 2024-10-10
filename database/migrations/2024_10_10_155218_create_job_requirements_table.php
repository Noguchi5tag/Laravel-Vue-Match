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
        Schema::create('job_requirements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // ユーザーIDと外部キー制約
            $table->string('job_category')->nullable(); // 職種
            $table->string('prefecture')->nullable(); // 都道府県
            $table->string('dutyStation')->nullable(); // 市町村
            $table->boolean('relocation')->default(0); // 転勤の有無
            $table->string('job_join')->nullable(); // 入社時期
            $table->string('employment_type')->nullable(); // 雇用形態
            $table->string('salary_type')->nullable(); // 月給か年収かのタイプ
            $table->integer('salary_amount')->nullable(); // 希望金額
            $table->string('particular_type')->nullable(); // こだわり条件
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_requirements');
    }
};
