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
        'search_keywords', // 検索キーワード
        'status', // 公開か非公開か

        'image1', // 画像1
        'image2', // 画像2
        'image3', // 画像3
        'image4', // 画像4
        'image5', // 画像5
    ];

    
    /**
     * search_keywordsを配列として取得するためのアクセサ
     */
    public function getSearchKeywordsAttribute($value)
    {
        return explode(',', $value); // カンマ区切りで配列に変換
    }

    /**
     * search_keywordsをカンマ区切りの文字列として保存するためのミューテタ
     */
    public function setSearchKeywordsAttribute($value)
    {
        $this->attributes['search_keywords'] = implode(',', $value); // 配列をカンマ区切りの文字列に変換
    }

    public function scopeSearchInertiaJobs(
        $query,
        $search = null, 
        $companySearch = null,
        $dutyStation = null, 
        $Occupation = null,
        $companyPay = null
    )
    {
        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('search_keywords', 'like', '%' . $search . '%');
            });
        }

        if (!empty($companySearch)) {
            $query->where(function($q) use ($companySearch) {
                $q->where('companyName', 'like', '%' . $companySearch . '%');
            });
        }
    
        if (!empty($dutyStation)) {
            $query->where('dutyStation', $dutyStation);
        }
    
        if (!empty($Occupation)) {
            $query->where('Occupation', $Occupation);
        }

        if (!empty($companyPay)) {
            switch ($companyPay) {
                case '150000':
                    $query->where('companyPay', '<=', 150000);
                    break;
                case '200000':
                    $query->whereBetween('companyPay', [150001, 200000]);
                    break;
                case '250000':
                    $query->whereBetween('companyPay', [200001, 250000]);
                    break;
                case '300000':
                    $query->whereBetween('companyPay', [250001, 300000]);
                    break;
                case '300001':
                    $query->where('companyPay', '>', 300001);
                    break;
            }
        }
    
        return $query;
    }
}
