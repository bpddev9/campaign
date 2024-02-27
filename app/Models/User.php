<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\{HasOne, HasMany};

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;


    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_no',
        'role',
        'political_group',
        'email_verified_at'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class);
    }

    public function socials(): HasMany
    {
        return $this->hasMany(UserSocial::class);
    }

    public function workExperiences(): HasMany
    {
        return $this->hasMany(WorkExperience::class);
    }

    public function qualifications(): HasMany
    {
        return $this->hasMany(Qualification::class);
    }

    public function certifications(): HasMany
    {
        return $this->hasMany(Certification::class);
    }

    public function publications(): HasMany
    {
        return $this->hasMany(Publication::class);
    }

    public function skill(): HasOne
    {
        return $this->hasOne(Skill::class);
    }

    public function employments(): HasMany
    {
        return $this->hasMany(Employment::class);
    }

    public function links(): HasMany
    {
        return $this->hasMany(Link::class);
    }

    public function companyProfile(): HasOne
    {
        return $this->hasOne(CompanyProfile::class);
    }

    public function resume(): HasOne
    {
        return $this->hasOne(Resume::class);
    }

    public function socialAccountLinked($service)
    {
        return (bool) $this->socials->where('service', $service)->count();
    }

    public function jobs(): BelongsToMany
    {
        return $this->belongsToMany(Employment::class, 'employment_user', 'user_id', 'employment_id')->withTimestamps();
    }

    public function certificates(): HasMany
    {
        return $this->hasMany(Certification::class)->where('type', 'certification');
    }

    public function awards(): HasMany
    {
        return $this->hasMany(Certification::class)->where('type', 'award');
    }

    public function savedJobs()
    {
        return $this->belongsToMany(Employment::class, 'saved_jobs', 'applicant_id', 'job_id')->withTimestamps();
    }
}
