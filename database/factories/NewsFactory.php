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
            'title' => $this->faker->sentence,        // 日本語のタイトルを生成
            'content' => $this->faker->paragraph(5),  // 日本語のコンテンツを生成
        ];
    }
}
