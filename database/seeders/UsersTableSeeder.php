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
        $names = [
            'nagasaki' => '長崎',
        ];

        foreach ($names as $name_en => $name_jp) {

            User::create([
                'name' => $name_jp, // ユーザー名
                'email' => $name_en .'@nagasaki.com', // メールアドレス
                'tel' => '000-0000-0000', // 電話番号
                'sex' => '3', // 性別
                'birth' => '2021-01-01', // 生年月日
                'postal' => '000-0000', // 郵便番号
                'prefectures' => '長崎県', // 都道府県
                'city' => '長崎市', // 市町村
                'password' => bcrypt('password'), // パスワード
            ]);

        }
    }
}