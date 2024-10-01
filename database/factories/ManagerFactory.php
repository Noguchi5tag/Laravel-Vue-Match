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
            'login_name' => '株式会社マネジャー',
            'email' => 'manager@manager.com',
            'password' => bcrypt('password'),
            'manager_url' =>'https://google.com',
            'tel_manager' =>'01012345678',
            'manager_address_number' => '8551234',
            'manager_address' => '長崎県長崎市賑町12-1',
            'business' => '病院：一般病棟165床',
            'recruit_manager' => '長崎太郎',
            'other_manager' => '株式会社マネジャーは、明治30年に三菱重工株式会社の福利厚生施設として設立され、昭和52年に一般保険医療機関の認可を受けて以降は、地域の方々の診療も行って参りましたが、平成28年4月より「医療法人 重工記念長崎病院」として独立しました。',
            'image_manager' => '',
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
