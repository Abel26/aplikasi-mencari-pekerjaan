<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'logo',
        'slug',
        'about',
        'employer_id',
    ];

    // untuk mengecek employer
    public function employeer()
    {
        return $this->belongsTo(User::class, 'employer_id');
    }

    public function jobs()
    {
        return $this->hasMany(CompanyJob::class);
    }
}
