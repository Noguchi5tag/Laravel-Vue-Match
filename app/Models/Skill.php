<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use app\Models\User;

class Skill extends Model
{
    use HasFactory;

    protected $fillable = [
        'skill_name',
        'skill_experience',
    ];

    public function user()
    {
        $this->hasMany(User::class);
    }
}
