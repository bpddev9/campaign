<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Contracts\Database\Eloquent\Builder;

class EmploymentUser extends Pivot
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'employment_id',
        'quest_ans',
        'is_rejected',
    ];

    protected $table = 'employment_user';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function employment()
    {
        return $this->belongsTo(Employment::class, 'employment_id');
    }
}
