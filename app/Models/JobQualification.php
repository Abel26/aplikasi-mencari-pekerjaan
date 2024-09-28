<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JobQualification extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'company_job_id'
    ];
}
