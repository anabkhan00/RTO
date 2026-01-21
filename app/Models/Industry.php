<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Industry extends Model implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'name',
        'description',
        'contact_person',
        'email',
        'phone',
        'address',
        'website',
        'status',
        'industry_status',
        'course_ids',
        'checklist_ids',
        'availability',
        'notes'
    ];

    protected $casts = [
        'status' => 'boolean',
        'course_ids' => 'array',
        'checklist_ids' => 'array',
        'availability' => 'array',
    ];

    public function weeklySchedules()
    {
        return $this->hasMany(IndustryWeeklySchedule::class);
    }

    public function courseChecklists()
    {
        return $this->hasMany(IndustryCourseChecklist::class);
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'industry_courses');
    }
}