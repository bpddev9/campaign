<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Employment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'job_title_id',
        'job_title',
        'job_type',
        'min_salary',
        'job_position',
        'max_salary',
        'no_of_people',
        'pay_rate',
        'job_description',
        'can_call',
        'can_post_resume',
        'location_type',
        'job_schedule',
        'appl_quest',
        'job_benefit'
    ];

    /**
     * Get the user that owns the Employment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeFormattedCompanyAddress(Builder $builder)
    {
        return $builder->addSelect([
            'location' => CompanyProfile::select(
                DB::raw("CONCAT(`street_address`,' ',`city`,', ',`state`)")
            )->whereColumn(
                'user_id',
                'employments.user_id'
            )->limit(1)
        ]);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'employment_user', 'user_id', 'employment_id')->withPivot('quest_ans', 'created_at', 'updated_at');
    }

    public function applicants()
    {
        return $this->belongsToMany(User::class, 'saved_jobs', 'job_id', 'applicant_id')->withTimestamps();
    }

    public function scopeApplicantCount(Builder $builder)
    {
        return $builder->addSelect([
            'users_count' => EmploymentUser::select(
                DB::raw("COUNT(user_id)")
            )->whereColumn(
                'employments.id',
                '=',
                'employment_user.employment_id'
            )->groupBy(
                'employment_user.employment_id'
            )->limit(1)
        ]);
    }

    public function appliedUsers()
    {
        return $this->belongsToMany(User::class, 'employment_user', 'user_id', 'employment_id')->withPivot('quest_ans', 'created_at', 'updated_at');
    }

    public function jobTitle()
    {
        return $this->belongsTo(JobTitle::class);
    }
}
