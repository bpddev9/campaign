<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobTitle extends Model
{
    use HasFactory;

    protected $fillable = [
        'industry_id',
        'position',
        'description',
    ];

    public function industry(){
        return $this->belongsTo(Industry::class);
    }

    public function employments(){
        return $this->hasMany(Employment::class);
    }
}
