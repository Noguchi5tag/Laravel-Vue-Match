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
            $table->integer('startWork')->after('Welfare');
            $table->integer('endWork')->after('startWork');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inertia_jobs', function (Blueprint $table) {
            $table->dropColumn('startWork');
            $table->dropColumn('endWork');
        });
    }
};
