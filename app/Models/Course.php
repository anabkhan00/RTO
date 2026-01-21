<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Course extends Model implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'name',
        'code',
        'credit_hours',
        'description',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];
    
    public function courseChecklist()
    {
        return $this->hasOne(CourseChecklist::class);
    }
}
