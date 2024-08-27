<?php

namespace Database\Factories;

use App\Models\InertiaJob;
use Illuminate\Database\Eloquent\Factories\Factory;

class InertiaJobFactory extends Factory
{
    protected $model = InertiaJob::class;

    public function definition()
    {
        $faker = $this->faker;
        $holidays = ['土曜日', '日曜日', '祝祭日'];

        $workDays = [];
        while (count($workDays) < 5) {
            $day = $faker->dayOfWeek;
            if (in_array($day, ['月曜日', '火曜日', '水曜日', '木曜日', '金曜日'])) {
                $workDays[] = $day;
            }
        }

        return [
            'companyName' => $faker->company,
            'WantedTitles' => $faker->jobTitle,
            'Occupation' => $faker->jobTitle,
            'companyAddress' => $faker->address,
            'companyPay' => $faker->numberBetween(300000, 1000000),
            'dutyStation' => $faker->city,
            'workDescription' => $faker->text,
            'payDescription' => $faker->text,
            'travelExpenses' => $faker->numberBetween(1000, 5000),
            'Welfare' => $faker->text,
            'startWork' => $faker->time,
            'endWork' => $faker->time,
            'workDays' => implode(', ', $workDays), // 月曜日～金曜日
            'freeDays' => $faker->randomElement($holidays), // 土曜日・日曜日・祝祭日
            'NearestStation' => $faker->streetName,
            'workOther' => $faker->text,
            'status' => $faker->randomElement([0, 1]), // 0: 非公開, 1: 公開
        ];
    }
}