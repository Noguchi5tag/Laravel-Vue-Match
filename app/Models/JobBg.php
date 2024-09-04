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
        'job_title',
        'company_name',
        'start_enrollment',
        'end_enrollment',
        'currently_working',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
