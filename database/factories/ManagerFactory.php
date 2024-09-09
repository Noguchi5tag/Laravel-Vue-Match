<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\manager>
 */
class ManagerFactory extends Factory
{
    protected $model = \App\Models\Manager::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => '株式会社マネジャー',
            'email' => 'manager@manager.com',
            'password' => bcrypt('password'),
            'login_name' => 'manager',
            'role' => 0,
            'Status' => 0,
        ];
    }

    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
