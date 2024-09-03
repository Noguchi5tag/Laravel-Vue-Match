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
        Schema::create('academic__bgs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onUpdate('cascade')->unique();
            $table->string('school_classification'); // 学校区分
            $table->string('school_name'); // 学校名
            $table->string('department'); // 学部・学科
            $table->date('matriculation'); // 入学
            $table->date('graduation')->nullable(); // 卒業（nullableにして、在学中の場合を考慮）
            $table->boolean('undergraduate')->default(false); // 在学中（デフォルトはfalse）
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('academic__bgs');
    }
};
