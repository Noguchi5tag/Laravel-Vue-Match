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
            $table->time('workDays')->nullable()->change();
            $table->time('freeDays')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inertia_jobs', function (Blueprint $table) {
            $table->string('workDays')->nullable()->change();
            $table->string('freeDays')->nullable()->change();
        });
    }
};
