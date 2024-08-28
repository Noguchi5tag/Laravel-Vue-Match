<?php

namespace Database\Seeders;

use App\Models\User;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        User::create([
            'name' => 'testuser', // ユーザー名
            'email' => 'test@test.com', // メールアドレス
            'tel' => '09012345678', // 電話番号
            'sex' => '1', // 性別
            'birth' => '2021-01-01', // 生年月日
            'postal' => '12134567', // 郵便番号
            'prefectures' => '長崎県', // 都道府県
            'city' => '長崎市万屋町12-1', // 市町村
            'password' => bcrypt('password'), // パスワード
            'status' => 1,
        ]);
    }
}