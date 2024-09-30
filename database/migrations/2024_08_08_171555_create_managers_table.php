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
        Schema::create('managers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('login_name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('tel_manager')->default('01012345678');
            $table->string('manager_address_number')->default('8551234'); //郵便番号
            $table->string('manager_address'); //住所
            $table->text('business'); //事業内容
            $table->string('recruit_manager'); //採用担当
            $table->text('other_manager'); //その他
            $table->integer('role')->default(1);
            $table->tinyInteger('status')->default(1);
            $table->string('image_manager')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('manager_password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('managers');
        Schema::dropIfExists('manager_password_reset_tokens');
    }
};
