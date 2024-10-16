<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'inertia_job_id', 'company_name', 'liked'];

    // 求人情報とのリレーション
    public function job()
    {
        return $this->belongsTo(InertiaJob::class, 'inertia_job_id');
    }


    // 求職者（ユーザー）とのリレーション
    // リレーション：応募者（Userモデル）を取得
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
