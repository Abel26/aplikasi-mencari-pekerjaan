<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CompanyJob extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'company_id',
        'category_id',
        'about',
        'salary',
        'skill_level',
        'location',
        'type',
        'is_open',
        'thumbnail',
    ];

    // 1 job hanya ada 1 category
    public function category(){
        return $this->belongsTo(Category::class, 'category_id');
    }

    // 1 job hanya ada 1 company
    public function company(){
        return $this->belongsTo(Company::class, 'company_id');
    }

    // 1 job memiliki banyak tanggung jawab
    public function responsibilities(){
        return $this->hasMany(JobResponsibility::class);
    }

    // 1 job memiliki banyak kualifikasi
    public function qualifications(){
        return $this->hasMany(JobQualification::class);
    }

    // 1 job memiliki banyak candidate
    public function candidates(){
        return $this->hasMany(JobCandidate::class);
    }
}
