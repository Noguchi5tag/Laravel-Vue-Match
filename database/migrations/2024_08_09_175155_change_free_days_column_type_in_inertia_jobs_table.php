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
        Schema::table('inertia_jobs', function (Blueprint $table) {
            $table->string('freeDays')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inertia_jobs', function (Blueprint $table) {
            $table->date('freeDays')->change(); // 元のデータ型に戻す
        });
    }
};
