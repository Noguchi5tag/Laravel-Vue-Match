<?php

namespace Database\Factories;

use App\Models\InertiaJob;
use Illuminate\Database\Eloquent\Factories\Factory;

class InertiaJobFactory extends Factory
{
    protected $model = InertiaJob::class;

    public function definition(): array
    {
        $companyNames = [];
        for ($i = 1; $i <= 99; $i++) {
            $companyNames[] = "株式会社テスト" . str_pad($i, 2, '0', STR_PAD_LEFT);
        }
    
        return [
            'companyName' => $this->faker->randomElement($companyNames),
            'WantedTitles' => $this->faker->randomElement(['営業マネージャー', '事務スタッフ', 'システムエンジニア', 'デザイナー', 'カスタマーサポート']),
            'Occupation' => $this->faker->randomElement(['営業', '事務', 'エンジニア', 'デザイナー', 'その他']),
            'companyAddress' => $this->faker->address,
            'companyPay' => $this->faker->numberBetween(150000, 500000),
            'dutyStation' => $this->faker->randomElement(['長崎市', '島原市', '南島原市', '諫早市', '雲仙市', '西海市', '五島市', '新上五島市', '松浦市', '壱岐市', '対馬市', '平戸市']),
            'workDescription' => $this->faker->text(200),
            'payDescription' => $this->faker->randomElement(['月給制', '年棒', '日払い']),
            'travelExpenses' => $this->faker->numberBetween(3000, 20000),
            'Welfare' => $this->faker->text(50),
            'startWork' => $this->faker->numberBetween(8, 10),
            'endWork' => $this->faker->numberBetween(17, 19),
            'workDays' => $this->faker->randomElement(['月～金', 'シフト制']),
            'freeDays' => $this->faker->randomElement(['土日', '週休2日制']),
            'NearestStation' => $this->faker->randomElement(['中央駅', '南駅', '東駅', '西駅', '北駅']),
            'workOther' => $this->faker->text(100),
            'status' => $this->faker->numberBetween(0, 1),
            'image1' => null,
            'image2' => null,
            'image3' => null,
            'image4' => null,
            'image5' => null,
        ];
    }
}