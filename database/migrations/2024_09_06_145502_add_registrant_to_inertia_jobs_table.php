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
            $table->string('registrant')->nullable()->comment('新規登録したユーザーネーム');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inertia_jobs', function (Blueprint $table) {
            if (Schema::hasColumn('inertia_jobs', 'registrant')) {
                $table->dropColumn('registrant');
            }
        });
    }
};
