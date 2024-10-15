<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InertiaJob extends Model
{
    use HasFactory;

    protected $fillable = [
        'companyName',          // 会社名
        'WantedTitles',         // 募集タイトル
        'Occupation',           // 職種
        'companyAddress',       // 会社の住所
        'prefecture',           // 勤務地 都道府県
        'dutyStation',          // 勤務地 市町村
        'relocation',           // 転勤の有無
        'workDescription',      // 仕事内容
        'employment_type',      // 雇用形態
        'job_join',             // 入社時期
        'salary_type',          // 月収か年収か
        'salary_amount',        // 給与
        'travelExpenses',       // 交通費
        'particular_type',      // こだわり条件
        'Welfare',              // 福利厚生
        'startWork',            // 勤務開始時間
        'endWork',              // 勤務終了時間
        'workDays',             // 出勤日
        'freeDays',             // 休日
        'NearestStation',       // 最寄り駅
        'workOther',            // その他
        'status',               // 公開か非公開か
        'registrant',           // 登録者
        'is_checked',           // 確認フラグ
        'search_keywords',      // 検索キーワード
        'image1',               // 画像1
        'image2',               // 画像2
        'image3',               // 画像3
        'image4',               // 画像4
        'image5',               // 画像5
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
        $companySearch = null,
        $Occupation = null, 
        $dutyStation = null, 
        $prefecture = null,
        $search = null,
        $salaryType = null,
        $selectedAmount = null,
        $particulars = null
        
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
    
        if (!empty($prefecture)) {
            $query->where('prefecture', $prefecture);
        }
    
        if (!empty($Occupation) && is_array($Occupation)) {
            $query->where(function($q) use ($Occupation) {
                foreach ($Occupation as $occupation) {
                    $q->orWhere('Occupation', 'like', '%' . $occupation . '%');
                }
            });
        }

         // こだわり条件（複数選択可）
        if (!empty($particulars) && is_array($particulars)) {
            $query->where(function($q) use ($particulars) {
                foreach ($particulars as $particular) {
                    // カンマで囲まれた文字列をLIKE検索で確認
                    $q->orWhere('particular_type', 'like', '%,' . $particular . ',%')
                    ->orWhere('particular_type', 'like', '%,' . $particular)
                    ->orWhere('particular_type', 'like', $particular . ',%')
                    ->orWhere('particular_type', $particular);
                }
            });
        }

        if (!empty($salaryType)) {
            $query->where('salary_type', $salaryType);

            if ($salaryType === '月給' && !empty($selectedAmount)) {
                // 月給の場合の金額条件
                switch ($selectedAmount) {
                    case '20':
                        $query->whereBetween('salary_amount', [200000, 299999]);
                        break;
                    case '30':
                        $query->whereBetween('salary_amount', [300000, 399999]);
                        break;
                    case '40':
                        $query->whereBetween('salary_amount', [400000, 499999]);
                        break;
                    case '50';
                        $query->where('salary_amount', '>', 500000);
                        break;
                }
            } elseif ($salaryType === '年収' && !empty($selectedAmount)) {
                // 年収の場合の金額条件
                switch ($selectedAmount) {
                    case '300':
                        $query->whereBetween('salary_amount', [3000001, 3999999]); // 300〜399万円
                        break;
                    case '400':
                        $query->whereBetween('salary_amount', [4000000, 4999999]); // 400〜499万円
                        break;
                    case '500':
                        $query->whereBetween('salary_amount', [5000000, 5999999]); // 500〜599万円
                        break;
                    case '600':
                        $query->whereBetween('salary_amount', [6000000, 6999999]); // 600〜699万円
                        break;
                    case '700':
                        $query->whereBetween('salary_amount', [7000000, 7999999]); // 700〜799万円
                        break;
                    case '800':
                        $query->whereBetween('salary_amount', [8000000, 8999999]); // 800〜899万円
                        break;
                    case '900':
                        $query->whereBetween('salary_amount', [9000000, 9999999]); // 900〜999万円
                        break;
                    case '1000':
                        $query->where('salary_amount', '>=', 10000000); // 1000万円以上
                        break;
                }
            }
        }
    
        // dd($query->toSql(), $query->getBindings());
        return $query;
    }

    public function bookmarkedByUsers()
    {
        return $this->belongsToMany(User::class, 'bookmarks', 'inertia_job_id', 'user_id')->withTimestamps();
    }

    public function applications()
    {
        return $this->belongsToMany(User::class, 'applications', 'inertia_job_id', 'user_id')->withTimestamps();
    }
}
