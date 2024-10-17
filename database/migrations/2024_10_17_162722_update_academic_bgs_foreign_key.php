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
        // academic_bgs テーブルに対して操作
        Schema::table('academic__bgs', function (Blueprint $table) {
            // 既存の外部キー制約を削除
            $table->dropForeign(['user_id']);

            // カスケード削除を有効にした新しい外部キーを追加
            $table->foreign('user_id')
                    ->references('id')->on('users')
                    ->onDelete('cascade'); // カスケード削除を設定
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        // academic_bgs テーブルに対して操作
        Schema::table('academic__bgs', function (Blueprint $table) {
            // 新しい外部キー制約を削除
            $table->dropForeign(['user_id']);

            // 元の外部キー制約を再追加（カスケード削除なし）
            $table->foreign('user_id')
                    ->references('id')->on('users')
                    ->onDelete('restrict'); // 削除禁止に戻す
        });
    }
};
