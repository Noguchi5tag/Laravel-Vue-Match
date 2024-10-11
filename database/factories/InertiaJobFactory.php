<?php

namespace Database\Factories;

use App\Models\InertiaJob;
use Illuminate\Database\Eloquent\Factories\Factory;

class InertiaJobFactory extends Factory
{
    protected $model = InertiaJob::class;

    public function definition(): array
    {
        // $companyNames = [];
        // for ($i = 1; $i <= 99; $i++) {
        //     $companyNames[] = "株式会社テスト" . str_pad($i, 2, '0', STR_PAD_LEFT);
        // }
    
        return [
            // 'companyName' => $this->faker->randomElement($companyNames),
            // 'WantedTitles' => $this->faker->randomElement(['営業マネージャー', '事務スタッフ', 'システムエンジニア', 'デザイナー', 'カスタマーサポート']),
            // 'Occupation' => $this->faker->randomElement(['営業', '事務', 'エンジニア', 'デザイナー', 'その他']),
            // 'companyAddress' => $this->faker->address,
            // 'dutyStation' => $this->faker->randomElement(['長崎市', '島原市', '南島原市', '諫早市', '雲仙市', '西海市', '五島市', '新上五島市', '松浦市', '壱岐市', '対馬市', '平戸市']),
            // 'workDescription' => $this->faker->realText(200),
            // 'travelExpenses' => $this->faker->numberBetween(3000, 20000),
            // 'Welfare' => $this->faker->realText(50),
            // 'startWork' => $this->faker->time('H:i', $this->faker->numberBetween(8, 10) . ':00'),
            // 'endWork' => $this->faker->time('H:i', $this->faker->numberBetween(17, 19) . ':00'),
            // 'workDays' => $this->faker->randomElement(['月～金', 'シフト制']),
            // 'freeDays' => $this->faker->randomElement(['土日', '週休2日制']),
            // 'NearestStation' => $this->faker->randomElement(['中央駅', '南駅', '東駅', '西駅', '北駅']),
            // 'workOther' => $this->faker->realText(100),
            // 'status' => $this->faker->numberBetween(0, 1),
            // 'image1' => $this->faker->randomElement([
            //     'test/test-1.jpg', 'test/test-2.jpg', 'test/test-3.jpg', 'test/test-4.jpg', 'test/test-5.jpg', 
            //     'test/test-6.jpg', 'test/test-7.jpg', 'test/test-8.jpg', 'test/test-9.jpg', 'test/test-10.jpg'
            // ]),
            // 'image2' => $this->faker->randomElement([
            //     'test/test-1.jpg', 'test/test-2.jpg', 'test/test-3.jpg', 'test/test-4.jpg', 'test/test-5.jpg', 
            //     'test/test-6.jpg', 'test/test-7.jpg', 'test/test-8.jpg', 'test/test-9.jpg', 'test/test-10.jpg'
            // ]),
            // 'image3' => $this->faker->randomElement([
            //     'test/test-1.jpg', 'test/test-2.jpg', 'test/test-3.jpg', 'test/test-4.jpg', 'test/test-5.jpg', 
            //     'test/test-6.jpg', 'test/test-7.jpg', 'test/test-8.jpg', 'test/test-9.jpg', 'test/test-10.jpg'
            // ]),
            // 'image4' => $this->faker->randomElement([
            //     'test/test-1.jpg', 'test/test-2.jpg', 'test/test-3.jpg', 'test/test-4.jpg', 'test/test-5.jpg', 
            //     'test/test-6.jpg', 'test/test-7.jpg', 'test/test-8.jpg', 'test/test-9.jpg', 'test/test-10.jpg'
            // ]),
            // 'image5' => $this->faker->randomElement([
            //     'test/test-1.jpg', 'test/test-2.jpg', 'test/test-3.jpg', 'test/test-4.jpg', 'test/test-5.jpg', 
            //     'test/test-6.jpg', 'test/test-7.jpg', 'test/test-8.jpg', 'test/test-9.jpg', 'test/test-10.jpg'
            // ]),
        ];
    }
}