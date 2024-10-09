<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Skill;
use App\Models\Academic_Bg;
use App\Models\JobBg;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'kana',
        'email',
        'password',
        'tel',        
        'sex',        
        'birth',      
        'postal',     
        'prefectures',
        'city',       
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'birth' => 'date', //追加
        ];
    }

    public function skills()
    {
        return $this->hasMany(Skill::class, 'user_id');
    }
    public function academic_bg()
    {
        return $this->hasOne(Academic_Bg::class, 'user_id');
    }
    public function job_bg()
    {
        return $this->hasOne(JobBg::class, 'user_id');
    }

    public function bookmarks()
    {
        return $this->belongsToMany(InertiaJob::class, 'bookmarks', 'user_id', 'inertia_job_id')->withTimestamps();
    }
}
