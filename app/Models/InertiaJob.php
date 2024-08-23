<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InertiaJob extends Model
{
    use HasFactory;

    protected $fillable = [
        'companyName', // 会社名
        'WantedTitles', // 募集タイトル
        'Occupation', // 職種
        'companyAddress', // 会社の住所
        'companyPay', // 給料
        'dutyStation', // 勤務地
        'workDescription', // 仕事内容
        'payDescription', // 給与詳細
        'travelExpenses', // 交通費
        'Welfare', // 福利厚生
        'startWork', // 勤務開始時間
        'endWork', // 勤務終了時間
        'workDays', // 出勤日
        'freeDays', // 休日
        'NearestStation', // 最寄り駅
        'workOther', // その他
        'status', // 公開か非公開か

        'image1', // 画像1
        'image2', // 画像2
        'image3', // 画像3
        'image4', // 画像4
        'image5', // 画像5
    ];
}
