<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use app\Models\User;

class JobBg extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'company_name',
        'company_business',
        'start_enrollment_year',
        'start_enrollment_month',
        'currently_working',
        'end_enrollment_year',
        'end_enrollment_month',
        'business_other',
        'company_post',
        'company_pay_type',
        'company_pay',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
