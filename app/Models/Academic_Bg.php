<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use app\Models\User;

class Academic_Bg extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'school_classification',
        'school_name',
        'department',
        'matriculation',
        'graduation',
        'undergraduate',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
