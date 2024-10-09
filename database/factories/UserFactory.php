<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = \App\Models\User::class;
    public function definition(): array
    {
        return [
            'name' => 'テスト太郎',
            'kana' => 'テストタロウ',
            'email' => 'test@test.com',
            'tel' => '09012345678',
            'sex' => '1',
            'birth' => '2001-01-01',
            'postal' => '8551234',
            'prefectures' => '長崎県',
            'city' => '長崎市万屋町12-1',
            'password' => bcrypt('password'), // パスワード
            'status' => 1,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
