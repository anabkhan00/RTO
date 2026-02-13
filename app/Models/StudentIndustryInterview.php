<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentIndustryInterview extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'industry_id',
        'interview_at',
        'status',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function industry()
    {
        return $this->belongsTo(Industry::class);
    }
}
