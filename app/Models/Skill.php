<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use app\Models\User;

class Skill extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'skill_name',
        'skill_experience',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
