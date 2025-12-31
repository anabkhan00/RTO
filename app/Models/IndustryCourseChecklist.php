<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IndustryCourseChecklist extends Model
{
    protected $fillable = [
        'industry_id',
        'course_id', 
        'checklist_ids'
    ];

    protected $casts = [
        'checklist_ids' => 'array'
    ];

    public function industry()
    {
        return $this->belongsTo(Industry::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function checklists()
    {
        return DocumentChecklist::whereIn('id', $this->checklist_ids ?? [])->get();
    }
}