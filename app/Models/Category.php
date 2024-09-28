<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'icon'
    ];

    // 1 category akan memiliki lebih dari 1 job
    public function jobs(){
        return $this->hasMany(CompanyJob::class);
    }
}
