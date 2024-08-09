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
            if (!Schema::hasColumn('inertia_jobs', 'startWork')) {
                $table->integer('startWork')->after('Welfare')->notNull();
            }
            if (!Schema::hasColumn('inertia_jobs', 'endWork')) {
                $table->integer('endWork')->after('startWork')->notNull();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inertia_jobs', function (Blueprint $table) {
            if (Schema::hasColumn('inertia_jobs', 'startWork')) {
                $table->dropColumn('startWork');
            }
            if (Schema::hasColumn('inertia_jobs', 'endWork')) {
                $table->dropColumn('endWork');
            }
        });
    }
};
