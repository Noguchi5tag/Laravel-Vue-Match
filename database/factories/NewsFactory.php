<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\News>
 */
class NewsFactory extends Factory
{
    protected $model = \App\Models\News::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->realText(10),
            'content' => $this->faker->realText(100),
        ];
    }
}
