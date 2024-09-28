<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobCandidate extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'message',
        'candidate_id',
        'resume',
        'is_hired',
        'company_job_id',
    ];

    // 1 candidate hanya ada 1 profile
    public function profile()
    {
        return $this->belongsTo(User::class, 'candidate_id');
    }

    // untuk mengecek candidate apply job
    public function job()
    {
        return $this->belongsTo(CompanyJob::class, 'company_job_id');
    }
}
