<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Industry extends Model
{
    use HasFactory;

    protected $fillable = [
        "title",
    ];

    public function jobTitles(){
        return $this->hasMany(JobTitle::class);
    }
}
