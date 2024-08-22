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
        Schema::table('users', function (Blueprint $table) {
            $table->string('tel')->after('email');
            $table->integer('sex')->after('tel'); // 性別を数値で管理
            $table->date('birth')->nullable()->after('sex');
            $table->string('postal')->after('birth');
            $table->string('prefectures')->after('postal');
            $table->string('city')->after('prefectures');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['tel', 'sex', 'birth', 'postal', 'prefectures', 'city']);
        });
    }
};