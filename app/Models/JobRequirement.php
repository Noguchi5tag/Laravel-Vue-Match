<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobRequirement extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'job_category',
        'prefecture',
        'dutyStation',
        'relocation',
        'job_join',
        'employment_type',
        'salary_type',
        'salary_amount' => 'integer',
        'particular_type',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
