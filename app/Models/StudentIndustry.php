<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentIndustry extends Model
{
    protected $fillable = [
        'student_id',
        'industry_id'
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function industry(): BelongsTo
    {
        return $this->belongsTo(Industry::class);
    }
}