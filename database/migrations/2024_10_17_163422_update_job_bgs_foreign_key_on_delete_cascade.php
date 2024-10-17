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
        Schema::table('job_bgs', function (Blueprint $table) {
            // 既存の外部キー制約を削除
            $table->dropForeign(['user_id']);
            
            // カスケード削除の外部キー制約を追加
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_bgs', function (Blueprint $table) {
            // カスケード削除を解除
            $table->dropForeign(['user_id']);
            
            // 元の外部キー制約を再追加
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');
        });
    }
};
